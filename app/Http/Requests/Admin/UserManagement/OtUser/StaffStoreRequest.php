<?php

namespace App\Http\Requests\Admin\UserManagement\OtUser;

use Illuminate\Foundation\Http\FormRequest;

class StaffStoreRequest extends FormRequest
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
            'employee_id' => 'required|unique:users|unique:sterilizations|unique:admins',
            'first_name' => 'required|string|max:200',
            'last_name' => 'nullable|string|max:200',
            'ot_name' => 'required|string|max:200',
            'reference_number' => 'required|string|max:50',
            'floor_number' => 'required|string|max:20',
            'room_number' => 'required|string|max:20',
            'mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:15|unique:users,mobile',
            'email' => 'required|email|unique:users,email|regex:/(.+)@(.+)\.(.+)/i|max:200',
            'profile_image' => "mimes:jpeg,jpg,png",
        ];
    }
}
