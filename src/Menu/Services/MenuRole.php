<?php

namespace Lenna\Admin\Menu\Services;

use Lenna\Admin\Menu\Repositories\MenuRole as RepositoryMenuRole;

class MenuRole {

    private $repositoryMenuRole;

    public function __construct(RepositoryMenuRole $repositoryMenuRole) {
        $this->repositoryMenuRole = $repositoryMenuRole;
    }

    public function editRoleMenu($roleId,array $menuIds) {
        $this->repositoryMenuRole->deleteWhere(['role_id' => $roleId]);
        foreach ($menuIds as $menuId) {
            $this->repositoryMenuRole->create([
                'role_id' => $roleId,
                'menu_id' => $menuId
            ]);
        }
    }

    public function fetchRoleMenuIsAllow($roleId, $menuId): bool {
        $dbCount = $this->repositoryMenuRole
            ->findWhere([
                ['role_id', '=', $roleId],
                ['menu_id', '=', $menuId]
            ])
            ->count();

        return $dbCount >= 1;
    }

    public function fetchRoleMenuId($roleIds) {
        $dbResult = $this->repositoryMenuRole
            ->findWhere([
                ['role_id', 'IN', $roleIds]
            ])
            ->map(function ($item) {
                return $item->menu_id;
            });
        return $dbResult->toArray();
    }
}
