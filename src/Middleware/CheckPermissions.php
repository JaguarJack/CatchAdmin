<?php

namespace JaguarJack\CatchAdmin\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class CheckPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $userId = $request->user($request->guard)->id;

        $route = Route::currentRouteName();

        list($controller, $action) = Str::parseCallback($request->route()->getAction('uses'));

        $controller = strtolower(str_replace('Controller', '', $controller));
        $action     = strtolower($action);

        // 获取 permissions

        // 获取对应 ROLE IDS
        return $next($request);
    }
}
