<?php

namespace Lenna\Admin\Menu\Repositories;

use Lenna\Admin\Models\Menu as ModelMenu;
use Prettus\Repository\Eloquent\BaseRepository;

class Menu extends BaseRepository {

    public function model() {
        // TODO: Implement model() method.
        return ModelMenu::class;
    }

    public function fetchMenuRootId($menuIds) {
        return $this->model
            ->whereIn('id', $menuIds)
            ->where('parent_id', '>', 0)
            ->groupBy('parent_id')
            ->get(['parent_id']);
    }
}
