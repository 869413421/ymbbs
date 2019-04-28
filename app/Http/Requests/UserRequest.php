<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required|between:3,25|unique:users,name,' . \Auth::id(),
            'email' => 'required|email',
            'introduction' => 'max:80',
            'head_img' => 'mimes:jpg,jpeg,png,gif|dimensions:min_width=208,min_height=208'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '请输入姓名',
            'email' => '邮箱不正确',
            'introduction.max' => '个人简介超出长度',
            'name.unique' => '用户名已被占用，请重新填写',
            'name.regex' => '用户名只支持英文、数字、横杠和下划线。',
            'name.between' => '用户名必须介于 3 - 25 个字符之间。',
            'name.required' => '用户名不能为空。',
            'head_img.dimensions' => '上传图片分辨率不正确'
        ];
    }
}
