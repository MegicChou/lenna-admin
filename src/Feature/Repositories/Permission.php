<?php

namespace Lenna\Admin\Feature\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Lenna\Admin\Models\Feature\Permission as ModelPermission;

class Permission extends BaseRepository {

    public function model() {
        // TODO: Implement model() method.
        return ModelPermission::class;
    }

    public function fetchAllCatalog(): array
    {
        return $this->model->where("parent_id", "=", 0)
            ->get()
            ->all();
    }

    public function fetchAllPermissionItem($parentId,$guardName): array
    {
        return $this->model
            ->where("guard_name","=", $guardName)
            ->where("parent_id", "=", $parentId)
            ->get()
            ->all();
    }
}
