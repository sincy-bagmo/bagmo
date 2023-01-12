<?php

namespace App\Http\Requests\Admin\Utility;

use Illuminate\Foundation\Http\FormRequest;

class WashMethodUpdateRequest extends FormRequest
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
            'method_name' => 'required|string|max:200|unique:lookup_wash_methods,method_name,' . $this->wash_method->id,
            'description' => 'nullable|max:200',
        ];
    }
}
