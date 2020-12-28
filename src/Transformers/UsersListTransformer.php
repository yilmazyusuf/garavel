<?php

namespace Garavel\Transformers;

use League\Fractal\TransformerAbstract;
use Garavel\Model\GaravelUserModel;

class UsersListTransformer extends TransformerAbstract {

    /**
     * @param AdminLteUserModel $user
     *
     * @return  array
     */
    public function transform(GaravelUserModel $user)
    {
        $actionButtons = [
            'edit'   => [
                'url'        => route('users.edit', [$user->id]),
                'icon_class' => 'fa-edit',
            ],
            'remove' => [
                'url'        => "javascript:SweetAlert.deleteUser('" . route('users.destroy', [$user->id]) . "');",
                'icon_class' => 'fa-trash',
            ]
        ];

        $permissions = collect($user->permissions->toArray());
        $roles = collect($user->roles->toArray());

        return [
            'id'          => (int)$user->id,
            'name'        => (string)$user->name,
            'email'       => (string)$user->email,
            'roles'       => (string)$roles->implode('name', ', '),
            'permissions' => (string)$permissions->implode('name', ', '),
            'is_tmd_auth' => (string)$user->isTmdAuthLabel,
            'status'      => (string)$user->statusLabel,
            'action'      => (string)$template = view()->make('adminlte::partials.btn_group', ['buttons' => $actionButtons])->render()
        ];
    }
}
