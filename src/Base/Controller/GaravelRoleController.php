<?php

namespace Garavel\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Garavel\Utils\Ajax;
use Garavel\Requests\StoreRoleFormRequest;
use Garavel\Requests\UpdateRoleFormRequest;
use Garavel\Transformers\RoleListTransformer;
use Garavel\ViewComposers\FlashMessageViewComposer;

class GaravelRoleController extends Controller {


    public function __construct()
    {
        $this->middleware(['permission:roles_management']);
    }

    public function index()
    {
        return view('adminlte::roles.index');
    }

    public function create()
    {
        $permissions = Permission::orderBy('name', 'asc')->get();

        return view('adminlte::roles.create', ['permissions' => $permissions]);
    }

    public function edit($roleId)
    {
        $role = Role::where('id', $roleId)->with('permissions')->first();
        if (!$role)
        {
            abort(404);
        }
        $permissions = Permission::orderBy('name', 'asc')->get();

        return view('adminlte::roles.edit', ['role' => $role, 'permissions' => $permissions]);
    }

    public function update(UpdateRoleFormRequest $request, $roleId)
    {
        $role = Role::where('id', $roleId)->with('permissions')->first();
        if (!$role)
        {
            abort(404);
        }

        $role->name = $request->get('name');
        $role->save();

        $permissions = $request->get('permissions');
        if (!is_null($permissions))
        {

            $getPermissions = Permission::whereIn('id', $permissions)->get();
            $role->syncPermissions($getPermissions);
        } else
        {
            foreach ($role->permissions as $rolePermission)
            {
                $role->revokePermissionTo($rolePermission);
            }

        }


        //Redirect
        $ajax = new Ajax();
        $request->session()->flash(FlashMessageViewComposer::MESSAGE_SUCCESS, 'Rol güncellendi.');

        return $ajax->redirect(route('roles.index'));
    }

    public function store(StoreRoleFormRequest $request)
    {

        $role = Role::create(['name' => $request->get('name')]);
        $permissions = $request->get('permissions');
        if (!is_null($permissions))
        {

            $getPermissions = Permission::whereIn('id', $permissions)->get();
            $role->syncPermissions($getPermissions);
        }


        //Redirect
        $ajax = new Ajax();
        $request->session()->flash(FlashMessageViewComposer::MESSAGE_SUCCESS, 'Yeni Rol oluşturuldu.');

        return $ajax->redirect(route('roles.index'));
    }

    public function destroy($roleId)
    {
        $role = Role::find($roleId);
        if (!$role)
        {
            abort(404);
        }
        $role->permissions()->detach();

        $role->delete();
        $ajax = new Ajax();
        request()->session()->flash(FlashMessageViewComposer::MESSAGE_SUCCESS, 'Rol silindi.');

        return $ajax->redirect(route('roles.index'));
    }


    public function indexDataTable(Request $request)
    {
        if ($request->ajax())
        {
            $permissions = Role::orderBy('name','asc')->with('permissions');

            return datatables()->eloquent($permissions)
                ->setTransformer(new RoleListTransformer())
                ->toJson();
        }

    }


}
