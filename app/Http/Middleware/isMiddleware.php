<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,  $roles): Response
    {
        $RoleId = ['admin' => 1, 'operator' => 2, 'user' => 3];
        $allowRoleId = [];
        foreach ($RoleId as $role) {
            if (isset($roleIds[$role])) {
                $allowRoleId[] = $roleIds[$role];
            }
        }
        if (auth()->check() && auth()->user()->RoleId == $allowRoleId) {
            return $next($request);
        } else {
            abort(403);
        }
    }
}
