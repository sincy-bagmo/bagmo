<?php

namespace App\Http\Requests\Admin\UserManagement\Collection;

use Illuminate\Foundation\Http\FormRequest;

class CollectionUserUpdateRequest extends FormRequest
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
            'employee_id' => 'required|unique:collections|unique:users|unique:admins|unique:sterilizations',
            'first_name' => 'required|string|max:200',
            'last_name' => 'nullable|string|max:200',
            'mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:15|unique:collections,mobile,' . $this->collection->id,
            'email' => 'required|email|regex:/(.+)@(.+)\.(.+)/i|max:200|unique:collections,email,' . $this->collection->id,
            'profile_image' => "mimes:jpeg,jpg,png",
        ];
    }
}
