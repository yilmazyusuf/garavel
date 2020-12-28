<?php

namespace Garavel\Transformers;

use League\Fractal\TransformerAbstract;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleListTransformer extends TransformerAbstract {

    /**
     * @param Permission $permission
     *
     * @return  array
     */
    public function transform(Role $role)
    {
        $actionButtons = [
            'edit'   => [
                'url'        => route('roles.edit', [$role->id]),
                'icon_class' => 'fa-edit',
            ],
            'remove' => [
                'url'        => "javascript:SweetAlert.deleteRole('" . route('roles.destroy', [$role->id]) . "');",
                'icon_class' => 'fa-trash',
            ]
        ];

        $permissions = collect($role->permissions->toArray());

        return [
            'id'          => (int)$role->id,
            'name'        => (string)$role->name,
            'permissions' => (string)$permissions->implode('name', ', '),
            'action'      => (string)$template = view()->make('adminlte::partials.btn_group', ['buttons' => $actionButtons])->render()
        ];
    }
}
