<?php

namespace App\Http\Middleware;

use App\Classes\RoleHelper;
use App\Models\Role_user;
use Closure;

class RoleMiddleware
{
    protected $role_user;
    protected $roleHelper;
    
    public function __construct(
        Role_user $role_user,
        RoleHelper $roleHelper)
    {
        $this->role_user = $role_user;
        $this->roleHelper = $roleHelper;
    }
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    
    public function handle(
        $request, Closure $next,
        $role)
    {
        $bool_has_role = $this->role_user->hasRole($role);
        if (!$bool_has_role)
        {
            return $this->roleHelper->no_authorization();
        }
        else
        {
            return $next($request);
        }
    }
}
