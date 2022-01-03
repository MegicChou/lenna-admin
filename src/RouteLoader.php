<?php

namespace Lenna\Admin;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\Route;
use Lenna\Admin\Http\Controllers\MenuController;
use Lenna\Admin\Http\Controllers\RoleController;
use Lenna\Admin\Http\Controllers\RolePermissionController;


class RouteLoader
{
    public static function loadRbacRoute()
    {
        $attributes = [
            'prefix'     => config('admin.route_prefix','admin'),
            'middleware' => array_merge(config('admin.middleware',[]),['web','admin']),
            'as'         => config('admin.route.as','admin.'),
        ];
        app('router')->group($attributes, function ($router) {
            /* @var \Illuminate\Routing\Router $router */
            $router->namespace("Leya\Admin\Http\Controllers")->group(function ($router) {
                /* @var \Illuminate\Routing\Router $router */
                $router->get("role",[RoleController::class,'index'])->name('role.index');
                $router->get('role/{id}',[RoleController::class,'find'])->name('role.find');
                $router->post("role",[RoleController::class,'create'])->name('role.create');
                $router->patch('role/{id}',[RoleController::class,'update'])->name('role.update');
                $router->delete("role/{id}",[RoleController::class,'destroy'])->name('role.destroy');
                $router->get('role/menu/{roleId}',[MenuController::class,'findRoleMenu'])->name('role.menu.index');
                $router->patch('role/menu/{roleId}',[MenuController::class,'editRoleMenu'])->name('role.menu.edit');
                $router->get('role/permission/{roleId}',[RolePermissionController::class,'index'])->name('role.permission.index');
                $router->patch('role/permission/{roleId}',[RolePermissionController::class,'edit'])->name('role.permission.edit');
            });
        });

        # load custom path file
        foreach (config('admin.route_files',[]) as $filePath) {
            app('router')->group($attributes,$filePath);
        }
    }
}
