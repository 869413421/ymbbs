<?php

namespace App\Http\Requests;

class ReplyRequest extends Request
{
    public function rules()
    {
        return [
            'content' => 'required|min:2'
        ];
    }

    public function messages()
    {
        return [
            'content' => '请输入评论内容！'
        ];
    }
}
