<?php

namespace App\Http\Requests\Admin\Inventory\Operation;

use Illuminate\Foundation\Http\FormRequest;

class OperationStoreRequest extends FormRequest
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
            'operation_name' => 'required|string|max:200|unique:operations,operation_name',
            'description' => 'nullable|max:200',
            'tray_category_id' => 'required',
        ];
    }
}
