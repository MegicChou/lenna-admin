<?php
namespace Lenna\Admin\Tests\Http\Middleware;

use Lenna\Admin\Http\Middleware\Exceptions\AccessDeniedException;
use Lenna\Admin\Models\Feature\Permission as ModelFeaturePermission;
use Lenna\Admin\Models\Feature\Route as ModelFeatureRoute;
use Lenna\Admin\Tests\User as ModelUser;
use Mockery;
use Lenna\Admin\Http\Middleware\Permission as MiddlewarePermission;
use Lenna\Admin\Tests\TestCase;

class PermissionTest extends TestCase {


    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        /** @var ModelFeatureRoute $modelFeatureRoute */
        $modelFeatureRoute = $this->app->make(ModelFeatureRoute::class);
        /** @var ModelFeaturePermission $modelFeaturePermission */
        $modelFeaturePermission = $this->app->make(ModelFeaturePermission::class);
        $resultPermission = $modelFeaturePermission->create([
            'parent_id'         => 1,
            'guard_name'        => 'web',
            'permission_name'   => 'admin.member.list',
            'name'              => '會員清單'
        ]);
        $modelFeatureRoute->create([
            'admin_feature_permissions_id' => $resultPermission->id,
            'route_name'                   => 'admin.member.list'
        ]);

    }

    public function test_route_is_allow()
    {
        $user = Mockery::spy(ModelUser::class);

        $user->shouldReceive('can')
            ->once()
            ->withArgs(['admin.member.list'])
            ->andReturn(true);

        # 創造假請求
        $req = \Illuminate\Http\Request::create('/aaa','GET');

        // @see https://stackoverflow.com/questions/41461497/simulate-a-http-request-and-parse-route-parameters-in-laravel-testcase
        $req->setRouteResolver(function () use ($req) {
            return (new \Illuminate\Routing\Route('GET','aaa',[]) )->name('admin.member.list')->bind($req);
        });

        # 參考一下這個人的 假使用者
        // @see https://stackoverflow.com/a/70826829
        $req->setUserResolver(function() use ($user) {
            return $user;
        });


        /** @var MiddlewarePermission $middleware */
        $middleware = $this->app->make(MiddlewarePermission::class);

        $middleware->handle($req, function () {
            $this->assertTrue(true);
        });
    }


    public function test_route_is_access_denied()
    {
        $this->expectException(AccessDeniedException::class);
        $user = Mockery::spy(ModelUser::class);

        $user->shouldReceive('can')
            ->once()
            ->withArgs(['admin.member.list'])
            ->andReturn(false);

        # 創造假請求
        $req = \Illuminate\Http\Request::create('/aaa','GET');

        // @see https://stackoverflow.com/questions/41461497/simulate-a-http-request-and-parse-route-parameters-in-laravel-testcase
        $req->setRouteResolver(function () use ($req) {
            return (new \Illuminate\Routing\Route('GET','aaa',[]) )->name('admin.member.list')->bind($req);
        });

        # 參考一下這個人的 假使用者
        // @see https://stackoverflow.com/a/70826829
        $req->setUserResolver(function() use ($user) {
            return $user;
        });

        /** @var MiddlewarePermission $middleware */
        $middleware = $this->app->make(MiddlewarePermission::class);

        $middleware->handle($req, function () {});
    }
}
