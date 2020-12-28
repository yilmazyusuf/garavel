<?php
/**
 *
 *
 * @category
 * @package
 * @author yusuf.yilmaz
 * @since  : 18.11.2020
 */

namespace Garavel\Croppie;

use Illuminate\Support\Facades\View;

trait  Croppie {

    public static function render($name = 'default', $targetModal = 'croppie_modal', $targetPath = 'croppie_target_path')
    {

        $croppies = config('croppie');
        $croppies[$name]['targetModal'] = $targetModal;
        $croppies[$name]['targetPath'] = $targetPath;
        $croppies[$name]['config_name'] = $name;
        $viewResponse = View::make('adminlte::croppie.index', ['params' => $croppies[$name]]);
        $sectionsRenderer = $viewResponse->render();

        return $sectionsRenderer;

    }

}
