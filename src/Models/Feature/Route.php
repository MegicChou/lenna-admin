<?php

namespace Lenna\Admin\Models\Feature;

use Illuminate\Database\Eloquent\Model;

class Route extends Model {

    protected $table = "admin_feature_route";

    protected $fillable = [
        "admin_feature_permissions_id",
        "route_name"
    ];


    public function permission(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Permission::class,'id');
    }
}
