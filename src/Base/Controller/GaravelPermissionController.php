<?php

namespace Garavel\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Garavel\Utils\Ajax;
use Garavel\Requests\StorePermissionFormRequest;
use Garavel\Requests\UpdatePermissionFormRequest;
use Garavel\Transformers\PermissionListTransformer;
use Garavel\ViewComposers\FlashMessageViewComposer;

class GaravelPermissionController extends Controller {

    public function __construct()
    {
        $this->middleware(['permission:permission_management']);
    }

    public function index()
    {
        return view('adminlte::permissions.index');
    }

    public function create()
    {
        return view('adminlte::permissions.create');
    }

    public function edit($permissionId)
    {
        $permission = Permission::find($permissionId);
        if (!$permission)
        {
            abort(404);
        }

        return view('adminlte::permissions.edit', ['permission' => $permission]);
    }

    public function update(UpdatePermissionFormRequest $request, $permissionId)
    {
        $permission = Permission::find($permissionId);
        if (!$permission)
        {
            abort(404);
        }

        $permission->name = $request->get('name');
        $permission->save();

        //Redirect
        $ajax = new Ajax();
        $request->session()->flash(FlashMessageViewComposer::MESSAGE_SUCCESS, 'Yetki güncellendi.');

        return $ajax->redirect(route('permissions.index'));
    }

    public function store(StorePermissionFormRequest $request)
    {

        $permission = Permission::create(['name' => $request->get('name')]);

        //Redirect
        $ajax = new Ajax();
        $request->session()->flash(FlashMessageViewComposer::MESSAGE_SUCCESS, 'Yeni yetki oluşturuldu.');

        return $ajax->redirect(route('permissions.index'));
    }

    public function destroy($permissionId)
    {
        $permission = Permission::find($permissionId);
        if (!$permission)
        {
            abort(404);
        }
        $permission->roles()->detach();
        $permission->delete();
        $ajax = new Ajax();
        request()->session()->flash(FlashMessageViewComposer::MESSAGE_SUCCESS, 'Yetki silindi.');

        return $ajax->redirect(route('permissions.index'));
    }


    public function indexDataTable(Request $request)
    {
        if ($request->ajax())
        {
            $permissions = Permission::query();

            return datatables()->eloquent($permissions)
                ->setTransformer(new PermissionListTransformer())
                ->toJson();
        }

    }


}
