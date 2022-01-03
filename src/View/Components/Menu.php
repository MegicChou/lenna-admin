<?php

namespace Lenna\Admin\View\Components;

use Illuminate\Http\Request;
use Illuminate\View\Component;
use Lenna\Admin\Menu\Managers\Menu as ManagerMenu;


class Menu extends Component
{

    private $request;

    private $managerMenu;

    public function __construct(Request $request, ManagerMenu $managerMenu)
    {
        $this->managerMenu = $managerMenu;
        $this->request = $request;
    }

    public function render()
    {
        // TODO: Implement render() method.
        $user = $this->request->user();

        $roleIds = $user->roles->map(function ($item) {
            return $item->id;
        })->toArray();

        $dbResultMenu = $this->managerMenu->fetchAllMenu();

        if (count($roleIds) >= 1) {
            $dbResultMenu = $this->managerMenu->fetchRoleMenu($roleIds);
        }

        return view('lenna-admin::menu.left-sidebar',['menu' => $dbResultMenu]);
    }
}
