<?php

namespace App\Http\Requests;

class TopicRequest extends Request
{
    public function rules()
    {
        switch ($this->method()) {
            // CREATE
            case 'POST':
                {
                    return [
                        // CREATE ROLES
                    ];
                }
            // UPDATE
            case 'PUT':
            case 'PATCH':
                {
                    return [
                        'title' => 'required|min:2',
                        'body' => 'required|min:10|max:2000',
                        'category_id' => 'required|numeric',
                    ];
                }
            case 'GET':
            case 'DELETE':
            default:
                {
                    return [];
                };
        }
    }

    public function messages()
    {
        return [
            'required' => '必须填写选项',
            'min' => '最小两个字符',
            'max' => '超出长度'
        ];
    }
}
