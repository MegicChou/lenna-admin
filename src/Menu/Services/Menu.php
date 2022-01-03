<?php

namespace Lenna\Admin\Menu\Services;

use Lenna\Admin\Menu\Repositories\Menu as RepositoryMenu;

class Menu {


    private $repositoryMenu;

    public function __construct(RepositoryMenu $repositoryMenu) {
        $this->repositoryMenu = $repositoryMenu;
    }

    public function fetchMenu(array $menuIds) {
        $dbResult =  $this->repositoryMenu
            ->fetchMenuRootId($menuIds);

        $rootIds = $dbResult->map(function ($item) {
            return $item->parent_id;
        })->toArray();

        $menus = [];

        $dbRootMenu = $this->repositoryMenu->findWhere([
            ['id', 'IN', $rootIds],
            ['parent_id', '=', 0]
        ])->sortByDesc('sortable');

        foreach ($dbRootMenu as $item) {
            $dbResultParentMenu = $this->repositoryMenu
                ->findWhere([
                    ['id', 'IN', $menuIds],
                    ['parent_id', '>', 0]
                ])->sortByDesc('sortable');
            $parentMenu = [];
            foreach ($dbResultParentMenu as $itemParentMenu) {
                $parentMenu[] = (object) [
                    'icon'      => $itemParentMenu->icon,
                    'name'      => $itemParentMenu->name,
                    'lang_name' => $itemParentMenu->lang_name,
                    'url'       => !empty($itemParentMenu->route_name) ? route($itemParentMenu->route_name) : ""
                ];
            }
            $menus[] = (object) [
                'name'      => $item->name,
                'icon'      => $item->icon,
                'lang_name' => $item->lang_name,
                'item'      => $parentMenu
            ];
        }
        return collect($menus);
    }

    public function fetchAllMenu(): \Illuminate\Support\Collection
    {
        $menus = [];

        $dbRootMenu = $this->repositoryMenu->findWhere([
            ['parent_id', '=', 0]
        ])->sortByDesc('sortable');

        foreach ($dbRootMenu as $item) {
            $dbResultParentMenu = $this->repositoryMenu
                ->findWhere([
                    ['parent_id', '=', $item->id]
                ])
                ->sortByDesc('sortable');
            $parentMenu = [];
            foreach ($dbResultParentMenu as $itemParentMenu) {
                $parentMenu[] = (object) [
                    'icon'      => $itemParentMenu->icon,
                    'name'      => $itemParentMenu->name,
                    'lang_name' => $itemParentMenu->lang_name,
                    'url'       => !empty($itemParentMenu->route_name) ? route($itemParentMenu->route_name) : ""
                ];
            }
            $menus[] = (object) [
                'name'      => $item->name,
                'icon'      => $item->icon,
                'lang_name' => $item->lang_name,
                'item'      => $parentMenu
            ];
        }
        return collect($menus);
    }
}
