<?php

namespace Garavel\Transformers;

use League\Fractal\TransformerAbstract;
use Garavel\Model\GaravelSettingModel;

class SettingListTransformer extends TransformerAbstract {

    /**
     * @param AdminLteSettingModel $settingModel
     *
     * @return  array
     */
    public function transform(GaravelSettingModel $settingModel)
    {
        $actionButtons = [
            'edit' => [
                'url'        => route('settings.edit', [$settingModel->id]),
                'icon_class' => 'fa-edit',
            ]
        ];

        if ($settingModel->is_changeable == 1)
        {
            $actionButtons['remove'] = [
                'url'        => "javascript:SweetAlert.deleteSetting('" . route('settings.destroy', [$settingModel->id]) . "');",
                'icon_class' => 'fa-trash',
            ];
        }


        return [
            'title'       => (string)$settingModel->title,
            'description' => (string)$settingModel->description,
            'key'         => (string)$settingModel->key,
            'value'       => (string)$settingModel->value,
            'action'      => (string)$template = view()->make('adminlte::partials.btn_group', ['buttons' => $actionButtons])->render()
        ];
    }
}
