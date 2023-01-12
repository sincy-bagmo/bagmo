<?php

namespace App\Http\Requests\Admin\Utility;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentUpdateRequest extends FormRequest
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
        return [
            'department_name' => 'required|string|max:200|unique:lookup_departments,department_name,' . $this->department->id,
            'description' => 'nullable|max:200',
        ];
    }
}
