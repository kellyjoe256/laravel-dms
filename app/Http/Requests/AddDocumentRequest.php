<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddDocumentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $before_date = date('Y-m');
        $before_date .= '-' . (date('d') + 1);

        $rules = [
            'title' => 'required|max:100|unique:document',
            'description' => 'required',
            'creation_date' => 'required|date_format:Y-m-d|before:' . $before_date,
            'category' => 'required|numeric|min:1',
            'branch' => 'nullable|numeric|min:1',
            'department' => 'nullable|numeric|min:1',
            'files' => 'required',
        ];

        list($count) = $this->getFilesInfo();
        foreach (range(0, $count) as $i) {
            $rules['files.' . $i] = 'allowed_files|max:5120';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'files.required' => 'You must at least upload one or more files',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'Title',
            'description' => 'Description',
            'creation_date' => 'Creation Date',
            'category' => 'Category',
            'branch' => 'Branch',
            'department' => 'Department',
            'files' => 'Files',
        ];
    }

    public function getFilesInfo()
    {
        $files = $this->file('files');
        return [count($files) - 1, $files];
    }
}
