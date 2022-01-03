<?php

namespace Lenna\Admin\Feature\Services;

use Lenna\Admin\Feature\Repositories\Permission as RepositoryPermission;

class Permission {

    /**
     * @var RepositoryPermission
     */
    private $repositoryPermission;

    public function __construct(RepositoryPermission $repositoryPermission) {
        $this->repositoryPermission = $repositoryPermission;
    }

    public function fetchAllCatalog(): array {
        return $this->repositoryPermission->fetchAllCatalog();
    }

    public function fetchAllPermissionItem($catalogId, $guardName): array {
        return $this->repositoryPermission
            ->fetchAllPermissionItem($catalogId,$guardName);
    }
}
