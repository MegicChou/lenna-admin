<?php

namespace Lenna\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class MenuRole extends Model {

    protected $table = "admin_menu_role";

    protected $fillable = [
        'role_id',
        'menu_id'
    ];
}
