<?php

namespace Lenna\Admin\Feature\Services;

use Lenna\Admin\Feature\Repositories\Route as RepositoryRoute;

class Route {

    /**
     * @var RepositoryRoute
     */
    private $repositoryRoute;

    public function __construct(RepositoryRoute $repositoryRoute)
    {
        $this->repositoryRoute = $repositoryRoute;
    }

    public function fetchRoutePermissionName($routeName) {
        $dbCount = $this->repositoryRoute
            ->findWhere(
                ['route_name' => $routeName]
            )
            ->count();

        if ($dbCount == 0) {
            return '';
        }

        $dbResult = $this->repositoryRoute
            ->findWhere(
                ['route_name' => $routeName]
            )
            ->first();

        return !empty($dbResult->permission->permission_name) ?
            $dbResult->permission->permission_name :
            "";
    }

}
