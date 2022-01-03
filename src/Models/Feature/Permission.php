<?php

namespace Lenna\Admin\Models\Feature;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model {

    protected $table = "admin_feature_permissions";

    protected $fillable = [
        "parent_id",
        "is_superuser",
        "permission_name",
        "guard_name",
        "name",
        "lang_name",
        "sortable"
    ];

    /**
     * 路由清單
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function route(): \Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany(Route::class,'admin_feature_permissions_id');
    }
}
