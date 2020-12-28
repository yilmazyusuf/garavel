<?php

namespace Garavel\Controller;

use App\Http\Controllers\Controller;
use Garavel\Model\GaravelUserModel;
use Garavel\Requests\StoreUserFormRequest;
use Garavel\Requests\UpdateUserFormRequest;
use Garavel\Utils\Ajax;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Garavel\Transformers\UsersListTransformer;
use Garavel\ViewComposers\FlashMessageViewComposer;
use Yajra\DataTables\DataTables;

class GaravelUserController extends Controller {

    /**
     * @var Datatables
     */
    private $dataTable;

    public function __construct(Datatables $dataTable)
    {
        $this->middleware(['permission:user_management']);
        $this->dataTable = $dataTable;

    }


    /**
     * Users.
     *
     * @return Renderable
     */
    public function index()
    {
        return view('adminlte::users.index');
    }

    public function create()
    {
        $permissions = Permission::orderBy('name', 'asc')->get();
        $roles = Role::orderBy('name', 'asc')->get();

        return view('adminlte::users.create', ['roles' => $roles, 'permissions' => $permissions]);
    }

    public function store(StoreUserFormRequest $request)
    {

        $user = new GaravelUserModel();
        $password = $request->get('password');
        $isTmdAuth = $request->get('tmd_auth', 0);
        $status = $request->get('status', 0);

        if (!is_null($password))
        {
            $user->password = Hash::make($password);
        }

        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->is_tmd_auth = $isTmdAuth;
        $user->status = $status;
        $user->save();


        //Permissions
        $permissions = $request->get('permissions');
        $user->syncPermissions($permissions);


        //Roles
        $roles = $request->get('roles');
        $user->syncRoles($roles);

        //Redirect
        $ajax = new Ajax();
        $request->session()->flash(FlashMessageViewComposer::MESSAGE_SUCCESS, 'Kullanıcı güncellendi.');

        return $ajax->redirect(route('users.index'));
    }

    public function edit($userId)
    {
        $user = GaravelUserModel::find($userId);
        if (!$user)
        {
            abort(404);
        }

        $permissions = Permission::orderBy('name', 'asc')->get();
        $roles = Role::orderBy('name', 'asc')->get();

        return view('adminlte::users.edit', ['user' => $user, 'roles' => $roles, 'permissions' => $permissions]);
    }

    public function update(UpdateUserFormRequest $request, $userId)
    {
        $user = GaravelUserModel::find($userId);
        if (!$user)
        {
            abort(404);
        }

        //Update User
        $password = $request->get('password');
        $isTmdAuth = $request->get('tmd_auth', 0);
        $status = $request->get('status', 0);

        if (!is_null($password))
        {
            $user->password = Hash::make($password);
        }

        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->is_tmd_auth = $isTmdAuth;
        $user->status = $status;
        $user->save();


        //Permissions
        $permissions = $request->get('permissions');
        $user->syncPermissions($permissions);


        //Roles
        $roles = $request->get('roles');
        $user->syncRoles($roles);

        //Redirect
        $ajax = new Ajax();
        $request->session()->flash(FlashMessageViewComposer::MESSAGE_SUCCESS, 'Kullanıcı güncellendi.');

        return $ajax->redirect(route('users.index'));
    }

    public function destroy($userId)
    {
        $user = GaravelUserModel::find($userId);
        if (!$user)
        {
            abort(404);
        }

        $user->syncPermissions(null);
        $user->syncRoles(null);

        $user->delete();
        $ajax = new Ajax();
        request()->session()->flash(FlashMessageViewComposer::MESSAGE_SUCCESS, 'Kullanıcı silindi.');

        return $ajax->redirect(route('users.index'));
    }

    public function indexDataTable(Request $request)
    {
        if ($request->ajax())
        {
            $users = GaravelUserModel::query();

            return datatables()->eloquent($users)
                ->setTransformer(new UsersListTransformer())
                ->toJson();
        }

    }

}
