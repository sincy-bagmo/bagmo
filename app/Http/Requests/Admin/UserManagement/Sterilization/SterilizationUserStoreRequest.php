<?php

namespace App\Http\Requests\Admin\UserManagement\Sterilization;

use Illuminate\Foundation\Http\FormRequest;

class SterilizationUserStoreRequest extends FormRequest
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
            'employee_id' => 'required|unique:users|unique:sterilizations|unique:admins',
            'first_name' => 'required|string|max:200',
            'last_name' => 'nullable|string|max:200',
            'mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:15|unique:sterilizations,mobile',
            'email' => 'required|email|unique:sterilizations,email|regex:/(.+)@(.+)\.(.+)/i|max:200',
            'profile_image' => "mimes:jpeg,jpg,png",
        ];
    }
}
