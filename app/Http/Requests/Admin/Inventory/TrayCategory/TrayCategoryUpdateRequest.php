<?php

namespace App\Http\Requests\Admin\Inventory\TrayCategory;

use Illuminate\Foundation\Http\FormRequest;

class TrayCategoryUpdateRequest extends FormRequest
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
            'category_name' => 'required|string|max:200|unique:categories,category_name,' . $this->tray_category->id,
            'description' => 'required|string|max:200',
            'code' => 'required|string|max:200|unique:tray_categories,code,' . $this->tray_category->id,
            'profile_image' => "mimes:jpeg,jpg,png",
        ];
    }
}
