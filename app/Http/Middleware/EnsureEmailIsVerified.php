<?php

namespace App\Http\Middleware;

use Closure;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = \Auth::user();

        if ($user &&
            !$user->hasVerifiedEmail() &&
            !$request->is('email/*', 'logout')
        ) {
            //如果是AJ请求就使用JSON返回,否者跳转到认证路由
            return $request->expectsJson()
                ? abort('403', '邮箱未认证!')
                : redirect()->route('verification.notice');
        }

        return $next($request);
    }
}
