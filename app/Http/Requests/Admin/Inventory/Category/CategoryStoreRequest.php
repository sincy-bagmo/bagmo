<?php

namespace App\Http\Requests\Admin\Inventory\Category;

use Illuminate\Foundation\Http\FormRequest;

class CategoryStoreRequest extends FormRequest
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
            'category_name' => 'required|string|max:200|unique:categories,category_name',
            'type' => 'required|integer|min:0|max:3',
            'weight' => 'required|numeric',
            'reference_number' => 'required|string|unique:categories,reference_number',
            'manufacturer' => 'required|string|max:200',
            'description' => 'required|string|max:200',
            'returnable' => 'required|integer|min:0|max:1',
            'wash_cycle' => 'required|integer|min:0|max:1',
            'code' => 'required|string|max:200|unique:categories,code',
            'profile_image' => "mimes:jpeg,jpg,png",
            'wash_method_id' => 'required',
        ];
    }
}
