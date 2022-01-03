<?php

namespace Lenna\Admin\Http\Middleware;

use Lenna\Admin\Http\Middleware\Exceptions\AccessDeniedException;
use Spatie\Permission\Traits\HasPermissions;
use Lenna\Admin\Feature\Services\Route as ServiceFeatureRoute;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Permission {


    private $serviceFeatureRoute;


    public function __construct(
        ServiceFeatureRoute $serviceFeatureRoute
    )
    {
        $this->serviceFeatureRoute = $serviceFeatureRoute;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        if ( !method_exists($request->user(),'can')  ) {
            abort(500,'user object not instanceof Authenticatable');
        }
        /** @var HasPermissions | Authenticatable $user */
        $user = $request->user();

        # 取得路由名稱
        $routeName = $request->route()->getName();

        $permissionName = $this->serviceFeatureRoute->fetchRoutePermissionName($routeName);

        if (!$user->can($permissionName)) {
            throw new AccessDeniedException();
        }

        return $next($request);
    }
}
