<?php

namespace Lenna\Admin\Http\Controllers;

use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lenna\Admin\Models\Menu as ModelMenu;
use Lenna\Admin\Menu\Services\MenuRole as ServiceMenuRole;
use Lenna\Admin\Menu\Managers\Menu as ManagerMenu;
use Spatie\Permission\Traits\HasRoles;
use Lenna\Admin\SuperUser\Services\User as ServiceSuperUser;


class MenuController extends Controller
{

    private $serviceMenuRole;

    public function __construct(ServiceMenuRole $serviceMenuRole)
    {
        $this->serviceMenuRole = $serviceMenuRole;
    }

    public function findRoleMenu($roleId,ModelMenu $modelMenu)
    {
        $menu = [];
        foreach ($modelMenu->all() as $itemMenu ) {
            if ( (bool) $itemMenu->is_superuser ) {
                continue;
            }
            $menu[] = (object) [
                'id'        => (string) $itemMenu->id,
                'parent'    => (empty($itemMenu->parent_id)) ? "#" : (string) $itemMenu->parent_id,
                'text'      => $itemMenu->name,
                'state'     => (object) ['selected' => $this->serviceMenuRole->fetchRoleMenuIsAllow($roleId,$itemMenu->id)]
            ];
        }

        return response()->json($menu);
    }


    public function editRoleMenu($roleId, Request $request): \Illuminate\Http\JsonResponse
    {
        $menuIds = $request->post('menuIds',[]);

        DB::beginTransaction();
        $this->serviceMenuRole->editRoleMenu($roleId,$menuIds);
        DB::commit();

        return response()->json(['status' => true]);
    }
}
