<?php

namespace App\Http\Requests\Admin\Utility\SurgicalWasher;

use Illuminate\Foundation\Http\FormRequest;

class SurgicalWasherUpdateRequest extends FormRequest
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
            'washer_name' => 'required|string|max:200',
            'company_name' => 'required|string|max:200',
            'procedure' => 'required',
            'remarks' => 'required|string|max:200',
        ];
    }
}
