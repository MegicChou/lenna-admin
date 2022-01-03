<?php

namespace Lenna\Admin\Models;

use Illuminate\Database\Seeder;
use Lenna\Admin\Models\Feature\Permission as ModelFeaturePermission;
use Lenna\Admin\Models\Feature\Route as ModelFeatureRoute;
use Spatie\Permission\Models\Permission as ModelSpatiePermission;

class AdminTablesSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createFeatureData();
        $this->createPermission();
    }


    private function createFeatureData()
    {
        ModelFeaturePermission::truncate();
        ModelFeatureRoute::truncate();

        $featureList = [
            (object) [
                'name'          => '角色管理',
                'guard_name'    => config('admin.default_guard','web'),
                'item' => [
                    (object) [
                        'permission_name' => 'admin.role.list',
                        'guard_name'      => config('admin.default_guard','web'),
                        'name'            => '角色清單列',
                        'lang_name'       => '',
                        'route'           => ['admin.role.index','admin.role.find']
                    ],
                    (object) [
                        'permission_name' => 'admin.role.create',
                        'guard_name'      => config('admin.default_guard','web'),
                        'name'            => '角色新增',
                        'lang_name'       => '',
                        'route'           => ['admin.role.create']
                    ],
                    (object) [
                        'permission_name' => 'admin.role.edit',
                        'guard_name'      => config('admin.default_guard','web'),
                        'name'            => '角色修改',
                        'lang_name'       => '',
                        'route'           => ['admin.role.update']
                    ],
                    (object) [
                        'permission_name' => 'admin.role.destroy',
                        'guard_name'      => config('admin.default_guard','web'),
                        'name'            => '角色刪除',
                        'lang_name'       => '',
                        'route'           => ['admin.role.destroy']
                    ]
                ]
            ],
            (object) [
                'name'          => '角色權限管理',
                'guard_name'    => config('admin.default_guard','web'),
                'item' => [
                    (object) [
                        'permission_name' => 'admin.role.permission.index',
                        'guard_name'      => config('admin.default_guard','web'),
                        'name'            => '角色權限頁',
                        'lang_name'       => '',
                        'route'           => ['admin.role.permission.index']
                    ],
                    (object) [
                        'permission_name' => 'admin.role.permission.edit',
                        'guard_name'      => config('admin.default_guard','web'),
                        'name'            => '角色權限-編輯',
                        'lang_name'       => '',
                        'route'           => ['admin.role.permission.edit']
                    ]
                ]
            ],
            (object) [
                'name'          => '角色選單',
                'guard_name'    => config('admin.default_guard','web'),
                'item' => [
                    (object) [
                        'permission_name' => 'admin.role.menu.edit',
                        'guard_name'      => config('admin.default_guard','web'),
                        'name'            => '角色選單編輯',
                        'lang_name'       => '',
                        'route'           => ['admin.role.menu.index','admin.role.menu.edit']
                    ],
                    (object) [
                        'permission_name' => 'admin.role.menu.list',
                        'guard_name'      => config('admin.default_guard','web'),
                        'name'            => '角色選單列表',
                        'lang_name'       => '',
                        'route'           => ['admin.menu.list']
                    ],
                ]
            ]
        ];

        foreach (config('admin.superuser_permission_name', []) as $permissionName) {
            ModelSpatiePermission::create([
                'name' => $permissionName,
                'guard_name' => config('admin.default_guard','web')
            ]);
        }
        $featureCatalogSortable = 1;
        foreach ($featureList as $itemFeatureCatalog) {
            $catalog = ModelFeaturePermission::create([
                'parent_id'     => 0,
                'name'          => $itemFeatureCatalog->name,
                'guard_name'    => $itemFeatureCatalog->guard_name,
                'sortable'      => $featureCatalogSortable++
            ]);

            $featureItemSortable = 1;
            foreach ($itemFeatureCatalog->item as $itemCatalogMenu) {
                $menu = ModelFeaturePermission::create([
                    'parent_id'       => $catalog->id,
                    'permission_name' => $itemCatalogMenu->permission_name,
                    'guard_name'      => $itemCatalogMenu->guard_name,
                    'lang_name'       => '',
                    'name'            => $itemCatalogMenu->name,
                    'sortable'        => $featureItemSortable++
                ]);

                foreach ($itemCatalogMenu->route as $routeName) {
                    ModelFeatureRoute::create([
                        'admin_feature_permissions_id' => $menu->id,
                        'route_name'                   => $routeName
                    ]);
                }
            }
        }
    }


    private function createPermission()
    {
        $dbResult = ModelFeaturePermission::where("parent_id", ">", 0)->get();

        foreach ($dbResult as $item) {
            ModelSpatiePermission::create([
                'name' => $item->permission_name,
                'guard_name' => $item->guard_name
            ]);
        }

    }
}
