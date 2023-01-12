<?php

namespace App\Http\Requests\Admin\Inventory\Trays;

use Illuminate\Foundation\Http\FormRequest;

class TrayStoreRequest extends FormRequest
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
            'department_id' => 'required|integer',
            'tray_category_id' => 'required|integer',
            'storage_rack_id' => 'required|integer',
            'tray_name' => 'required|string|max:200|unique:trays,tray_name',
            'profile_image' => "mimes:jpeg,jpg,png",
        ];
    }
}
