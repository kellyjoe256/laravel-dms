<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditDocumentRequest extends FormRequest
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

        return [
            'title' => 'required|max:100',
            'description' => 'required',
            'creation_date' => 'required|date_format:Y-m-d|before:' . $before_date,
            'category' => 'required|numeric|min:1',
            'branch' => 'nullable|numeric|min:1',
            'department' => 'nullable|numeric|min:1',
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
        ];
    }
}
