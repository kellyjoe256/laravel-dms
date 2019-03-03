<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadDocumentFilesRequest extends FormRequest
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
        $rules = [
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
            'files' => 'Files',
        ];
    }

    public function getFilesInfo()
    {
        $files = $this->file('files');
        return [count($files) - 1, $files];
    }
}
