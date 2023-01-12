<?php

namespace App\Http\Requests\Admin\BloodBag;

use Illuminate\Foundation\Http\FormRequest;

class BloodBagStoreRequest extends FormRequest
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
            'refrigerator_id' => 'required',
            'storage_rack_id' => 'required',
            'blood_bag_name' => 'required|string',
            'type' => 'required|string',
            'blood_group' => 'required|string',
            'product_id' => 'required|string',
            'volume' => 'required',
            'expiry_date' => 'required|date'
        ];
    }
}
