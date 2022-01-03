<?php

namespace Lenna\Admin\RolePermissions\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;

class Role extends BaseRepository {

    public function model() {
        // TODO: Implement model() method.
        return \Spatie\Permission\Models\Role::class;
    }

}
