<?php

namespace App\Http\Requests\Admin\Inventory\Instruments;

use Illuminate\Foundation\Http\FormRequest;

class InstrumentStoreRequest extends FormRequest
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
            'category_id' => 'required|integer',
            'serial_number' => 'required|string|unique:instrument_items,serial_number',
            'expiry' => 'required|date',
            'model' => 'required|string|max:200',
        ];
    }
}
