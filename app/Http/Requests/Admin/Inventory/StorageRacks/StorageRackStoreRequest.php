<?php

namespace App\Http\Requests\Admin\Inventory\StorageRacks;

use Illuminate\Foundation\Http\FormRequest;

class StorageRackStoreRequest extends FormRequest
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
            'rack_name' => 'required|string|max:200|unique:storage_racks,rack_name',
            'description' => 'nullable|string|max:200',
            'room_number' => 'required|integer|unique:storage_racks,room_number',
            'rack_number' => 'required|integer',
        ];
    }
}
