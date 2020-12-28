<?php
/**
 *
 *
 * @category
 * @package
 * @author yusuf.yilmaz
 * @since  : 30.01.2020
 */

namespace Garavel\ViewComposers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Garavel\Model\GaravelMenuModel;

class MenuComposer {


    protected $user;

    /**
     * MenuComposer constructor.
     */
    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function compose(View $view)
    {
        $menus = GaravelMenuModel::with(['permission', 'role'])->get();

        $menuList = $this->listMenu($menus);

        $view->with('menus', $menuList);

    }


    private function listMenu($rows, $parent = 0, &$key = 0)
    {
        $ulClass = $key == 0 ? 'class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu"
    data-accordion="false"' : 'class="nav nav-treeview"';

        $result = "<ul $ulClass>";

        foreach ($rows as $row)
        {


            $key++;

            $menuHasRole = isset($row->role) ? $row->role->name : false;
            $menuHasPermission = isset($row->permission) ? $row->permission->name : false;
            //var_dump($this->user->can('pages_managament'));

            $hasPermission = true;

            if ($menuHasRole !== false && $this->user->hasRole($menuHasRole) === false)
            {
                $hasPermission = false;
            }

            if ($menuHasPermission !== false && $this->user->can($menuHasPermission) === false)
            {
                $hasPermission = false;
            }

            if ($row->parent_id == $parent && $hasPermission === true)
            {

                $hasChildren = $this->has_children($rows, $row->id);

                $isMenuActive = '/' . $row->href == request()->getRequestUri() ? 'active' : '';


                if ($hasChildren)
                {
                    $result .= "<li class='nav-item has-treeview'><a href='{$row->href}' class='nav-link {$isMenuActive}'> <i class='{$row->icon}'></i> <p>{$row->text}<i class='right fas fa-angle-left'></i></p></a>";
                } else
                {
                    $result .= "<li class='nav-item'><a href='/{$row->href}' class='nav-link {$isMenuActive}'> <i class='{$row->icon}'></i> <p>{$row->text}</p></a>";
                }

                if ($hasChildren)
                {

                    $result .= $this->listMenu($rows, $row->id, $key);
                }
                $result .= "</li>";
            }
        }
        $result .= "</ul>";

        return $result;

    }

    private function has_children($rows, $id)
    {
        foreach ($rows as $row)
        {
            if ($row->parent_id == $id)
                return true;
        }

        return false;
    }


}
