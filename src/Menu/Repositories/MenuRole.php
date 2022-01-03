<?php

namespace Lenna\Admin\Menu\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Lenna\Admin\Models\MenuRole as ModelMenuRole;

class MenuRole extends BaseRepository {

    public function model() {
        // TODO: Implement model() method.
        return ModelMenuRole::class;
    }
}
