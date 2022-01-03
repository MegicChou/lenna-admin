<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_feature_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->default(0)->index();
            $table->boolean('is_superuser')->default(false);
            $table->string('permission_name')->default('');
            $table->string('guard_name',100);
            $table->string('name',100);
            $table->string('lang_name', 100)->default('');
            $table->tinyInteger('sortable')->default(0);
            $table->timestamps();
        });
        Schema::create('admin_feature_route', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_feature_permissions_id')->index();
            $table->string('route_name')->unique();
            $table->timestamps();
        });
        Schema::create('admin_menu', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->default(0)->index();
            $table->boolean('is_superuser')->default(false);
            $table->string('icon')->default('');
            $table->string('name');
            $table->string('lang_name')->default('');
            $table->string('route_name');
            $table->json('route_param')->nullable();
            $table->tinyInteger('sortable')->default(0);
            $table->timestamps();
        });
        Schema::create('admin_menu_role', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id')->index();
            $table->unsignedBigInteger('menu_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_feature_permissions');
        Schema::dropIfExists('admin_feature_route');
        Schema::dropIfExists('admin_menu');
        Schema::dropIfExists('admin_menu_role');
    }
}
