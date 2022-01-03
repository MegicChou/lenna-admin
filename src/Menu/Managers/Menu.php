<?php

namespace Lenna\Admin\Menu\Managers;

use Lenna\Admin\Menu\Services\Menu as ServiceMenu;
use Lenna\Admin\Menu\Services\MenuRole as ServiceMenuRole;

class Menu {

    private $serviceMenuRole;

    private $serviceMenu;

    public function __construct(
        ServiceMenuRole $serviceMenuRole,
        ServiceMenu $serviceMenu
    ) {
        $this->serviceMenuRole = $serviceMenuRole;
        $this->serviceMenu     = $serviceMenu;
    }

    public function fetchRoleMenu($roleIds): \Illuminate\Support\Collection
    {
        $menuIds = $this->serviceMenuRole->fetchRoleMenuId($roleIds);
        return $this->serviceMenu->fetchMenu($menuIds);
    }

    public function fetchAllMenu(): \Illuminate\Support\Collection
    {
        return $this->serviceMenu->fetchAllMenu();
    }
}
