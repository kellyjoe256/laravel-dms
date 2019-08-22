<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Document;
use App\DocumentCategory as Category;
use App\DocumentFile;
use App\Http\Requests\AddDocumentRequest;
use App\Http\Requests\EditDocumentRequest;
use App\Http\Requests\UploadDocumentFilesRequest;
use Illuminate\Http\Request;

class DocumentsController extends Controller
{
    public function index()
    {
        $branches = [];
        if (is_admin()) {
            $branches = Branch::selectRaw('branch_id, branch_name')
                ->orderBy('branch_name')
                ->pluck('branch_name', 'branch_id')
                ->toArray();
        }

        $query_builder = Document::selectRaw('
                document_id, title, description, creation_date,
                username, category_name, branch_name, department_name,
                document.created_at
            ')->leftJoin('user', 'document.user_id', '=', 'user.user_id')
            ->leftJoin('document_category', 'document.category_id', '=', 'document_category.category_id')
            ->leftJoin('branch', 'document.branch_id', '=', 'branch.branch_id')
            ->leftJoin('department', 'document.department_id', '=', 'department.department_id');

        if (request('title_desc')) {
            $title_desc = request('title_desc') . '*';
            $query_builder->whereRaw('MATCH(title, description) AGAINST (? IN BOOLEAN MODE)', [$title_desc]);
        }

        if (request('start_date') && request('end_date')) {
            $start_date = request('start_date');
            $end_date = request('end_date');
            $query_builder->whereRaw('creation_date BETWEEN ? AND ?', [
                $start_date, $end_date,
            ]);
        }

        // only search amongst branches if you are an admin
        if (request('branch') && is_admin()) {
            $query_builder->whereRaw('document.branch_id = ?', [
                (int) request('branch'),
            ]);
        } else if (!is_admin()) {
            // if not an admin, only show documents that belong to your branch
            $query_builder->whereRaw('document.branch_id = ?', [
                (int) auth()->user()->branch_id,
            ]);
        }

        // only search among departments if you are an admin
        if (request('department') && is_admin()) {
            $query_builder->whereRaw('document.department_id = ?', [
                (int) request('department'),
            ]);
        } else if (!is_admin()) {
            // if not an admin, only show documents that belong to your
            // department
            $query_builder->whereRaw('document.department_id = ?', [
                (int) auth()->user()->department_id,
            ]);
        }

        $documents = $query_builder->orderByRaw('creation_date DESC')
            ->paginate(env('PAGE_SIZE', 10));

        $data = [
            'title' => 'Documents',
            'documents' => $documents,
            'branches' => $branches,
        ];

        return view('main/documents/index', $data);
    }

    public function create()
    {
        if (!$this->checkCredentials()) {
            return redirect()->route('documents')->with([
                'class' => 'alert-danger',
                'message' => 'Ask your administrator to assign you a branch and department first',
            ]);
        }

        $branches = [];
        if (is_admin()) {
            $branches = Branch::selectRaw('branch_id, branch_name')
                ->orderBy('branch_name')
                ->pluck('branch_name', 'branch_id')
                ->toArray();
        }

        $categories = Category::selectRaw('category_id, category_name')
            ->orderBy('category_name')
            ->pluck('category_name', 'category_id')
            ->toArray();

        $data = [
            'title' => 'Add Document',
            'branches' => $branches,
            'categories' => $categories,
        ];

        return view('main/documents/create', $data);
    }

    public function store(AddDocumentRequest $request)
    {
        $uploaded_files = $request->file('files');
        $files = [];
        $upload_destination = $this->getUploadDestination();
        foreach ($uploaded_files as $uploaded_file) {
            list($upload_success, $filename) = upload_file(
                $uploaded_file, $upload_destination);

            if (!$upload_success) {
                break;
            }

            array_push($files, $filename);
        }

        if (!$upload_success) {
            return back()->with([
                'class' => 'alert-danger',
                'message' => 'Unable to upload one of the files, please try again',
            ]);
        }

        $document = new Document;
        $document->title = $request->title;
        $document->description = $request->description;
        $document->creation_date = $request->creation_date;
        $document->user_id = auth()->user()->user_id;
        $document->category_id = $request->category;
        if (is_admin()) {
            $document->branch_id = $request->branch;
            $document->department_id = $request->department;
        } else {
            $document->branch_id = auth()->user()->branch_id;
            $document->department_id = auth()->user()->department_id;
        }
        $document->save();

        $document_files = [];
        foreach ($files as $file) {
            array_push($document_files, [
                'filename' => $file,
                'document_id' => $document->document_id,
            ]);
        }

        DocumentFile::insert($document_files);

        return redirect()->route('documents')->with([
            'class' => 'alert-success',
            'message' => 'Document added successfully',
        ]);
    }

    public function edit($document_id)
    {
        if (!$this->checkCredentials()) {
            return redirect()->route('documents')->with([
                'class' => 'alert-danger',
                'message' => 'Ask your administrator to assign you a branch and department first',
            ]);
        }

        $document = Document::findOrFail((int) $document_id);

        if (!$this->canModify($document->branch_id, $document->department_id)) {
            return redirect()->route('documents')->with([
                'class' => 'alert-danger',
                'message' => 'You don\'t have the neccesary permissions',
            ]);
        }

        $branches = [];
        if (is_admin()) {
            $branches = Branch::selectRaw('branch_id, branch_name')
                ->orderBy('branch_name')
                ->pluck('branch_name', 'branch_id')
                ->toArray();
        }

        $categories = Category::selectRaw('category_id, category_name')
            ->orderBy('category_name')
            ->pluck('category_name', 'category_id')
            ->toArray();

        $data = [
            'title' => 'Edit Document',
            'document' => $document,
            'branches' => $branches,
            'categories' => $categories,
        ];

        return view('main/documents/edit', $data);
    }

    public function update(EditDocumentRequest $request, $document_id)
    {
        $document = Document::findOrFail((int) $document_id);

        if ($document->title != $request->title) {
            $this->validate($request, [
                'title' => 'unique:document',
            ], [], ['title' => 'Title']);
        }

        $document->title = $request->title;
        $document->description = $request->description;
        $document->creation_date = $request->creation_date;
        $document->category_id = $request->category;
        if (is_admin()) {
            $document->branch_id = $request->branch;
            $document->department_id = $request->department;
        }
        $document->save();

        return redirect()->route('documents')->with([
            'class' => 'alert-success',
            'message' => 'Document edited successfully',
        ]);
    }

    public function delete($document_id)
    {
        $document = Document::findOrFail((int) $document_id);

        if (!$this->canModify($document->branch_id, $document->department_id)) {
            return redirect()->route('documents')->with([
                'class' => 'alert-danger',
                'message' => 'You don\'t have the neccesary permissions',
            ]);
        }

        $data = [
            'title' => 'Delete Document',
            'document' => $document,
        ];

        return view('main/documents/delete', $data);
    }

    public function destroy(Request $request, $document_id)
    {
        if ($request->submit == 'Cancel') {
            return redirect()->route('documents');
        }

        $document = Document::findOrFail((int) $document_id);

        $flash_message_attributes = [];
        $files_store = $this->getUploadDestination();
        if ($request->submit == 'Delete Document') {
            // get files associated with document
            $files = $document->files->pluck('filename', 'file_id')->toArray();
            $placeholder = '(';
            // delete files associated with document
            foreach ($files as $file) {
                $temp = $files_store . DIRECTORY_SEPARATOR . $file;
                if (file_exists($temp)) {
                    @unlink($temp);
                }
                $placeholder .= '?, ';
            }
            $placeholder .= ')';
            $placeholder = replace_character($placeholder, '?, )', '?)');

            if ($placeholder != '(') {
                // delete files reference from the database
                DocumentFile::whereRaw(
                    'file_id IN ' . $placeholder,
                    array_keys($files)
                )->delete();
            }

            // delete the document
            $document->delete();

            $flash_message_attributes = [
                'class' => 'alert-success',
                'message' => 'Document deleted successfully',
            ];
        }

        return redirect()->route('documents')
            ->with($flash_message_attributes);
    }

    public function viewFiles($document_id)
    {
        $document = Document::findOrFail((int) $document_id);

        if (!$this->canModify($document->branch_id, $document->department_id)) {
            return redirect()->route('documents')->with([
                'class' => 'alert-danger',
                'message' => 'You don\'t have the neccesary permissions',
            ]);
        }

        $files = $document->files->pluck('filename', 'file_id')->toArray();

        $data = [
            'title' => $document->title . ' <em>Files</em>',
            'document' => $document,
            'files' => $files,
        ];

        return view('main/documents/view_files', $data);
    }

    public function uploadFiles($document_id)
    {
        $document = Document::findOrFail((int) $document_id);

        if (!$this->canModify($document->branch_id, $document->department_id)) {
            return redirect()->route('documents')->with([
                'class' => 'alert-danger',
                'message' => 'You don\'t have the neccesary permissions',
            ]);
        }

        $data = [
            'title' => 'Upload Files',
            'document' => $document,
        ];

        return view('main/documents/upload_files', $data);
    }

    public function storeFiles(UploadDocumentFilesRequest $request, $document_id)
    {
        $document = Document::findOrFail((int) $document_id);

        $uploaded_files = $request->file('files');
        $files = [];
        $upload_destination = $this->getUploadDestination();
        foreach ($uploaded_files as $uploaded_file) {
            list($upload_success, $filename) = upload_file(
                $uploaded_file, $upload_destination);

            if (!$upload_success) {
                break;
            }

            array_push($files, $filename);
        }

        if (!$upload_success) {
            return back()->with([
                'class' => 'alert-danger',
                'message' => 'Unable to upload one of the files, please try again',
            ]);
        }

        $document_files = [];
        foreach ($files as $file) {
            array_push($document_files, [
                'filename' => $file,
                'document_id' => $document->document_id, // or just $document_id
            ]);
        }

        DocumentFile::insert($document_files);

        return redirect()->route('documents.view_files', [$document_id])->with([
            'class' => 'alert-success',
            'message' => 'Files uploaded successfully',
        ]);
    }

    private function getUploadDestination()
    {
        $upload_destination = public_path() . DIRECTORY_SEPARATOR;
        $upload_destination .= 'static/uploads';
        return $upload_destination;
    }

    /**
     * Check the credentials of the user that is not an admin
     * and is able to add, edit or delete a document
     * 
     * @return boolean
     */
    private function checkCredentials()
    {
        $user = auth()->user();
        if (!is_admin() && !$user->branch_id && !$user->department_id) {
            return false;
        }

        return true;
    }

    /**
     * Check if user who is not an admin has belongs to
     * to the same branch and department as document being edited
     * 
     * @param int $doc_branch_id Document branch_id
     * @param int $doc_department_id Document department_id
     * @return boolean
     */
    private function canModify($doc_branch_id, $doc_department_id)
    {
        $user = auth()->user();
        if (!is_admin()
            && !($user->branch_id == $doc_branch_id)
            && !($user->department_id == $doc_department_id)
        ) {
            return false;
        }

        return true;
    }
}
