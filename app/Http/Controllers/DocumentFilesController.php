<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DocumentFile;

class DocumentFilesController extends Controller
{
    public function preview($file_id)
    {
        $file = DocumentFile::findOrFail((int)$file_id);
        $files_store = $this->getUploadDestination();
        // Preview Files
        preview_file($file->filename, $files_store);
    }

    public function deleteFile($file_id)
    {
        $file = DocumentFile::findOrFail((int)$file_id);
        $document_id = (int)request('document');

        if (!$document_id) {
            return back();
        }

        $files_store = $this->getUploadDestination();
        $full_path_to_file = $files_store . DIRECTORY_SEPARATOR;
        $full_path_to_file .= $file->filename;
        // Delete file if it exists
        if (file_exists($full_path_to_file)) {
            @unlink($full_path_to_file);
        }

        // Delete file reference in the database
        $file->delete();

        return redirect()->route('documents.view_files', [$document_id])->with([
            'class' => 'alert-success',
            'message' => 'File deleted successfully',
        ]);
    }

    private function getUploadDestination()
    {
        $upload_destination = public_path() . DIRECTORY_SEPARATOR;
        $upload_destination .= 'static/uploads';
        return $upload_destination;
    }
}
