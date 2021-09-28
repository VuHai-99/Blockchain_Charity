<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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

            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
            'address' => 'required|string|max:255',
            'phone' => "required|digits:10",
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên của bạn.',
            'name.max' => 'Tên không dài quá 255 kí tự',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã được đăng kí. Vui lòng sử dụng email khác.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.confirmed' => 'Mật khẩu xác nhận không trùng khớp.',
            'address.required' => 'Vui lòng nhập địa chỉ của bạn.',
            'address.max' => 'Địa chỉ không quá 255 kí tự',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.digits' => 'Số điện thoại không đúng định dạng.'
        ];
    }
}
