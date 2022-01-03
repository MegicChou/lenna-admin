<?php

namespace Lenna\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model {

    protected $table = "admin_menu";

    protected $fillable = [
        "parent_id",
        "is_superuser",
        "icon",
        "name",
        "lang_name",
        "route_name",
        "route_param",
        "sortable"
    ];
}
