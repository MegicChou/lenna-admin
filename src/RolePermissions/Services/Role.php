<?php

namespace Lenna\Admin\RolePermissions\Services;

use Lenna\Admin\RolePermissions\Repositories\Role as RepositoryRole;

class Role {

    /**
     * @var RepositoryRole
     */
    private $repositoryRole;

    public function __construct(RepositoryRole $repositoryRole) {
        $this->repositoryRole = $repositoryRole;
    }

    public function fetchRoleById($roleId) {
        return $this->repositoryRole->findWhere(['id' => $roleId])->first();
    }

}
