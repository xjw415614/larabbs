<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Handlers\ImageUploadHandler;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }
    // __construct 是 PHP 的构造器方法，当一个类对象被创建之前该方法将会被调用。
    // 我们在 __construct 方法中调用了 middleware 方法，该方法接收两个参数，第
    // 一个为中间件的名称，第二个为要进行过滤的动作。通过 except 方法来设定 指定动作
    // 不使用 Auth 中间件进行过滤，意为 —— 除了此处指定的动作以外，所有其他动作都必
    // 须登录用户才能访问，类似于黑名单的过滤机制。相反的还有 only 白名单方法，将只
    // 过滤指定动作。我们提倡在控制器 Auth 中间件使用中，首选 except 方法，这样的
    // 话，当你新增一个控制器方法时，默认是安全的，此为最佳实践。

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        // 这里 update 是指授权类里的 update 授权方法，$user 对应传参 update 授权方法
        // 的第二个参数。正如上面定义 update 授权方法时候提起的，调用时，默认情况下，我们
        // 不需要 传递第一个参数，也就是当前登录用户至该方法内，因为框架会 自动 加载当前登录用户。
        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {
        $this->authorize('update', $user);
        $data = $request->all();

        if ($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatars', $user->id,362);
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }

        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }
}
