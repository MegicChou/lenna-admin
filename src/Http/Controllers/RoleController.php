<?php

namespace Lenna\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Lenna\Admin\Http\Requests\Role\RoleRequest;
use Spatie\Permission\Models\Role as ModelRole;

class RoleController extends Controller {

    /**
     * @var ModelRole
     */
    private $modelRole;

    public function __construct(ModelRole $modelRole) {
        $this->modelRole = $modelRole;
    }

    public function index()
    {
        $resultRole = $this->modelRole->all();
        return view('lenna-admin::role.index',[
            "result" => $resultRole
        ]);
    }

    public function create(RoleRequest $request): \Illuminate\Http\JsonResponse {
        $this->modelRole->name = $request->post('name');
        $this->modelRole->save();
        return response()->json(['status' => true]);
    }

    public function update($id,RoleRequest $request): \Illuminate\Http\JsonResponse {
        $result = $this->modelRole->find($id);
        $result->name = $request->post('name');
        $result->save();
        return response()->json(['status' => true]);
    }

    public function destroy($id): \Illuminate\Http\JsonResponse {
        $this->modelRole->find($id)->delete();
        return response()->json(['status' => true]);
    }

    public function find($id): \Illuminate\Http\JsonResponse {
        $result = $this->modelRole->find($id);
        return response()->json(['result' => $result]);
    }
}
