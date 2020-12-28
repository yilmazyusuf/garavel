<?php

namespace Garavel\Transformers;

use League\Fractal\TransformerAbstract;
use Spatie\Permission\Models\Permission;

class PermissionListTransformer extends TransformerAbstract {

    /**
     * @param Permission $permission
     *
     * @return  array
     */
    public function transform(Permission $permission)
    {
        $actionButtons = [
            'edit'   => [
                'url'        => route('permissions.edit', [$permission->id]),
                'icon_class' => 'fa-edit',
            ],
            'remove' => [
                'url'        => "javascript:SweetAlert.deletePermission('" . route('permissions.destroy', [$permission->id]) . "');",
                'icon_class' => 'fa-trash',
            ]
        ];

        return [
            'id'     => (int)$permission->id,
            'name'   => (string)$permission->name,
            'action' => (string)$template = view()->make('adminlte::partials.btn_group', ['buttons' => $actionButtons])->render()
        ];
    }
}
