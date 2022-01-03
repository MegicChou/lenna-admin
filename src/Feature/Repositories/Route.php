<?php

namespace Lenna\Admin\Feature\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Lenna\Admin\Models\Feature\Route as ModelFeatureRoute;

class Route extends BaseRepository {

    public function model() {
        // TODO: Implement model() method.
        return ModelFeatureRoute::class;
    }
}
