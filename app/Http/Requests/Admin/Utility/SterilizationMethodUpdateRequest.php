<?php

namespace App\Http\Requests\Admin\Utility;

use Illuminate\Foundation\Http\FormRequest;

class SterilizationMethodUpdateRequest extends FormRequest
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
            'sterilization_method_name' => 'required|string|max:200|unique:sterilization_methods,sterilization_method_name,' . $this->sterilization_method->id,
            'description' => 'nullable|max:200',
        ];
    }
}
