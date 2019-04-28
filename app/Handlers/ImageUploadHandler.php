<?php

namespace App\Handlers;

class ImageUploadHandler
{
    protected $allow_ext = ['png', 'jpg', 'jpeg', 'gif'];

    public function save($file, $floder, $file_pix, $mix_width = false)
    {
        $ext = strtolower($file->getClientOriginalExtension()) ?: 'png';

        if (!in_array($ext, $this->allow_ext)) {
            return false;
        }

        $floder_name = 'upload/imgs/' . $floder . '/' . date('Y-m-d', time());

        $upload_path = public_path() . '/' . $floder_name;

        $file_name = $file_pix . '_' . date('Y-m-d', time()) . '_' . str_random(10) . '.' . $ext;

        $file->move($upload_path, $file_name);

        if ($mix_width && $ext != 'gif') {
            $this->reduceSize($upload_path . '/' . $file_name, $mix_width);
        }

        return config('app.url') . "/$floder_name/$file_name";
    }

    public function reduceSize($file_path, $mix_width)
    {
        $img = \Image::make($file_path);

        $img->resize($mix_width, null, function ($constraint) {
            // 设定宽度是 $max_width，高度等比例双方缩放
            $constraint->aspectRatio();
            // 防止裁图时图片尺寸变大
            $constraint->upsize();
        });

        $img->save();
    }
}