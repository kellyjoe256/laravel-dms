<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddDocumentCategoryRequest;
use App\Http\Requests\EditDocumentCategoryRequest;
use App\DocumentCategory as Category;

class DocumentCategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::selectRaw('
                category_id, category_name
            ')->orderByRaw('category_name')
            ->paginate(env('PAGE_SIZE', 10));

        $data = [
            'title' => 'Document Categories',
            'categories' => $categories,
        ];

        return view('main/document_categories/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Add Category',
        ];

        return view('main/document_categories/create', $data);
    }

    public function store(AddDocumentCategoryRequest $request)
    {
        $category = new Category;
        $category->category_name = ucfirst($request->category_name);
        $category->save();

        return redirect()->route('doc_categories')->with([
            'class' => 'alert-success',
            'message' => 'Category added successfully',
        ]);
    }

    public function edit($category_id)
    {
        $columns = ['category_id', 'category_name'];
        $category = Category::findOrFail((int) $category_id, $columns);

        $data = [
            'title' => 'Edit Category',
            'category' => $category,
        ];

        return view('main/document_categories/edit', $data);
    }

    public function update(EditDocumentCategoryRequest $request, $category_id)
    {
        $category = Category::findOrFail((int)$category_id);

        if ($category->category_name != $request->category_name) {
            $this->validate($request, [
                'category_name' => 'unique:document_category',
            ], [], ['category_name' => 'Category Name']);
        }

        $category->category_name = $request->category_name;
        $category->save();

        return redirect()->route('doc_categories')->with([
            'class' => 'alert-success',
            'message' => 'Category edited successfully',
        ]);
    }

    public function delete($category_id)
    {
        $columns = ['category_id', 'category_name'];
        $category = Category::findOrFail((int) $category_id, $columns);

        $data = [
            'title' => 'Delete Category',
            'category' => $category,
        ];

        return view('main/document_categories/delete', $data);
    }

    public function destroy(Request $request, $category_id)
    {
        if ($request->submit == 'Cancel') {
            return redirect()->route('doc_categories');
        }

        $category = Category::findOrFail((int) $category_id);

        $flash_message_attributes = [];
        if ($request->submit == 'Delete Category') {
            $category->delete();

            $flash_message_attributes = [
                'class' => 'alert-success',
                'message' => 'Category deleted successfully',
            ];
        }

        return redirect()->route('doc_categories')
            ->with($flash_message_attributes);
    }
}
