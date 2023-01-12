<?php

namespace App\Http\Requests\Admin\Inventory\TrayCategory;

use Illuminate\Foundation\Http\FormRequest;

class TrayCategoryStoreRequest extends FormRequest
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
            'category_name' => 'required|string|max:200|unique:tray_categories,category_name',
            'description' => 'required|string|max:200',
            'wash_cycle_days' => 'required|integer|min:1',
            'weight' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'code' => 'required|string|max:200|unique:tray_categories,code',
        ];
    }
}
