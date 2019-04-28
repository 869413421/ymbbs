<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Models\User;
use App\Http\Requests\UserRequest;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, ImageUploadHandler $img_hander, User $user)
    {
        $this->authorize('update', $user);
        $data = $request->all();

        if ($request->head_img) {
            $result = $img_hander->save($request->head_img, 'head_img', \Auth::id(), 416);
            if ($result) {
                $data['head_img'] = $result;
            }
        }

        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', '资料更新成功');
    }
}
