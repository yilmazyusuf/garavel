<?php

namespace Garavel\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Garavel\Utils\Ajax;
use Garavel\Model\GaravelMenuModel;
use Garavel\ViewComposers\FlashMessageViewComposer;

class GaravelMenuController extends Controller {

    private $menus;

    public function __construct()
    {
        $this->middleware(['permission:menu_management']);

    }

    public function index()
    {

        $menus = GaravelMenuModel::all();
        $this->menus = $menus->toArray();
        $listMenu = $this->listMenu($this->menus);
        $routes = [];
        foreach (Route::getRoutes()->getIterator() as $route)
        {

            if (array_search('GET', $route->methods()) !== false &&
                strpos($route->uri, 'api') === false &&
                strpos($route->uri, 'data_table') === false &&
                strpos($route->uri, 'file-manager') === false &&
                strpos($route->uri, 'password') === false &&
                strpos($route->uri, 'ignition') === false &&
                strpos($route->uri, '{') === false &&
                $route->uri != '/' &&
                $route->uri != 'login' &&
                $route->uri != 'register'
            )
            {
                $routes[] = $route->uri;
            }
        }

        $routes[] = 'telescope';
        sort($routes);

        $roles = Role::all();
        $permissions = Permission::all();

        $data = [
            'menus'       => array_values($listMenu),
            'routes'      => $routes,
            'roles'       => $roles,
            'permissions' => $permissions,
        ];

        return view('adminlte::menus.index', $data);
    }

    public function store(Request $request)
    {
        GaravelMenuModel::truncate();
        $menus = json_decode($request->getContent(), true);

        $this->saveMenus($menus);
        //Redirect
        $ajax = new Ajax();
        $request->session()->flash(FlashMessageViewComposer::MESSAGE_SUCCESS, 'Menüler güncellendi');

        return $ajax->redirect(route('menus.index'));
    }


    private function saveMenus($menus, &$key = 0, $parent = 0, $level = 0)
    {

        foreach ($menus as $menu)
        {
            $key++;
            $menuModel = new GaravelMenuModel();
            $menuModel->parent_id = $level == 0 ? 0 : $parent;
            $menuModel->text = $menu['text'];
            $menuModel->icon = $menu['icon'] == 'empty' ? 'far fa-circle nav-icon' : $menu['icon'];
            $menuModel->href = $menu['href'];
            $menuModel->role_id = $menu['role_id'] > 0 ? $menu['role_id'] :null;
            $menuModel->permission_id = $menu['permission_id'] > 0 ? $menu['permission_id'] :null;
            $menuModel->save();

            if (isset($menu['children']))
            {
                $parent = $key;
                $this->saveMenus($menu['children'], $key, $parent, $level + 1);
            }

        }

    }


    private function listMenu(array &$menus, $parentId = 0)
    {
        $branch = [];

        foreach ($menus as $element)
        {

            if ($element['parent_id'] == $parentId)
            {
                $children = $this->listMenu($menus, $element['id']);
                if ($children)
                {
                    $element['children'] = array_values($children);
                }
                $branch[$element['id']] = $element;
                unset($menus[$element['id']]);
            }
        }

        return $branch;
    }


}
