<?php

namespace Lenna\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lenna\Admin\RolePermissions\Managers\RolePermission as ManagerRolePermission;
use Spatie\Permission\Models\Role as ModelSpatieRole;

class RolePermissionController extends Controller {

    public function index($roleId,ManagerRolePermission $managerRolePermission) {
        $featureCatalog = $managerRolePermission->fetchAllRolePermissionForView($roleId);

        return view('lenna-admin::role.permission', [
            'featureCatalogGrid' => $featureCatalog,
            'roleId'             => $roleId
        ]);
    }


    public function edit($roleId, Request $request, ModelSpatieRole $modelSpatieRole) {
        DB::beginTransaction();
        /** @var ModelSpatieRole $role */
        $role = $modelSpatieRole->find($roleId);
        # 刪除原有的
        $removePermission = [];
        foreach ($role->getAllPermissions() as $itemPermission) {
            $removePermission[] = $itemPermission->name;
        }
        if (count($removePermission) >= 1) {
            $role->revokePermissionTo($removePermission);
        }

        # 重新賦予權限
        if ($request->has('permission')) {
            $role->givePermissionTo($request->post('permission'));
        }

        DB::commit();
        noty(__('lenna-admin::common.toast.edit.success'),'success');
        return response()->redirectToRoute('admin.role.permission.index',[$roleId]);
    }

}
