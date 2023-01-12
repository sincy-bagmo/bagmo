<?php

namespace App\Http\Requests\Admin\Refrigerator;

use Illuminate\Foundation\Http\FormRequest;

class RefrigeratorUpdateRequest extends FormRequest
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
            'refrigerator_name' => 'required|string|max:200|unique:refrigerators,refrigerator_name,' . $this->refrigerator->id ,
            'type' => 'required|string',
            'reference_number' => 'required|integer',
            'company' => 'required|string',
            'indication_name' => 'required|string',
            'remarks' => 'nullable|string',
        ];
    }
}
