<?php

namespace Lenna\Admin\RolePermissions\Managers;

use Lenna\Admin\Feature\Services\Permission as ServiceFeaturePermission;
use Lenna\Admin\RolePermissions\Services\Role as ServiceRole;

class RolePermission {

    /**
     * @var ServiceFeaturePermission
     */
    private $serviceFeaturePermission;

    /**
     * @var ServiceRole
     */
    private $serviceRole;

    public function __construct(
        ServiceFeaturePermission $serviceFeaturePermission,
        ServiceRole $serviceRole
    ) {
        $this->serviceFeaturePermission = $serviceFeaturePermission;
        $this->serviceRole = $serviceRole;
    }

    public function fetchAllRolePermissionForView($roleId): array {
        # 每個角色都會有一個 guard name 拿出來
        $role = $this->serviceRole->fetchRoleById($roleId);
        # 拉出該角色權限 記錄ID
        $isAllowGuardPermissions = [];
        foreach ($role->permissions as $itemPermission) {
            $isAllowGuardPermissions[] = $itemPermission->guard_name . "_" . $itemPermission->name;
        }
        $dbResultCatalog = $this->serviceFeaturePermission
            ->fetchAllCatalog();
        $rtnData = [];
        foreach ($dbResultCatalog as $itemCatalog) {
            $dbResultCatalogItem = $this->serviceFeaturePermission
                ->fetchAllPermissionItem($itemCatalog->id,'web');
            if (count($dbResultCatalogItem) == 0) {
                continue;
            }

            $features = [];
            foreach ($dbResultCatalogItem as $itemFeature) {
                $features[] = (object) [
                    'id'                => $itemFeature->id,
                    'name'              => $itemFeature->name,
                    'langName'          => $itemFeature->lang_name,
                    'isSuperuser'       => (bool) $itemFeature->is_superuser,
                    'enabled'           => in_array("{$itemFeature->guard_name}_{$itemFeature->permission_name}",$isAllowGuardPermissions),
                    'permissionName'    => $itemFeature->permission_name
                ];
            }
            $rtnData[] = (object) [
                'catalogName'       => $itemCatalog->name,
                'catalogLangName'   => $itemCatalog->lang_name,
                'isSuperuser'       => (bool) $itemCatalog->is_superuser,
                'item'              => $features
            ];
        }

        return $rtnData;
    }

}
