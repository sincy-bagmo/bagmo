<?php

namespace App\Http\Requests\Admin\UserManagement\Sterilization;

use Illuminate\Foundation\Http\FormRequest;

class SterilizationUserUpdateRequest extends FormRequest
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
            'employee_id' => 'required|unique:users,employee_id,'  . $this->sterilization->id , 'unique:sterilizations,employee_id,' .  $this->sterilization->id , 'unique:admins,employee_id,' . $this->sterilization->id,
            'first_name' => 'required|string|max:200',
            'last_name' => 'nullable|string|max:200',
            'mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:15|unique:sterilizations,mobile,' . $this->sterilization->id,
            'email' => 'required|email|regex:/(.+)@(.+)\.(.+)/i|max:200|unique:sterilizations,email,' . $this->sterilization->id,
            'profile_image' => "mimes:jpeg,jpg,png",
        ];
    }
}
