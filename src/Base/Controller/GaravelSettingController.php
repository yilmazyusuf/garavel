<?php

namespace Garavel\Controller;

use App\Http\Controllers\Controller;
use Garavel\Model\GaravelSettingModel;
use Garavel\Requests\UpdateSettingFormRequest;
use Garavel\Transformers\SettingListTransformer;
use Garavel\Utils\Ajax;
use Illuminate\Http\Request;
use Garavel\ViewComposers\FlashMessageViewComposer;

class GaravelSettingController extends Controller {


    public function __construct()
    {
        $this->middleware(['permission:settings_management']);
    }

    public function index()
    {
        return view('adminlte::settings.index');
    }

    public function create()
    {
        return view('adminlte::settings.create');
    }

    public function edit($settingId)
    {
        $setting = GaravelSettingModel::find($settingId);
        if (!$setting)
        {
            abort(404);
        }

        return view('adminlte::settings.edit', ['setting' => $setting]);
    }

    public function update(UpdateSettingFormRequest $request, $settingId)
    {
        $setting = GaravelSettingModel::find($settingId);
        if (!$setting)
        {
            abort(404);
        }

        $setting->title = $request->get('title');
        $setting->description = $request->get('description');
        if ($setting->is_changeable == 1)
        {
            $setting->key = $request->get('key');
        }

        $setting->value = $request->get('value');

        $setting->save();

        //Redirect
        $ajax = new Ajax();
        $request->session()->flash(FlashMessageViewComposer::MESSAGE_SUCCESS, 'Ayar güncellendi.');

        return $ajax->redirect(route('settings.index'));
    }

    public function store(UpdateSettingFormRequest $request)
    {

        $setting = new GaravelSettingModel();
        $setting->title = $request->get('title');
        $setting->description = $request->get('description');
        $setting->key = $request->get('key');
        $setting->value = $request->get('value');
        $setting->save();

        //Redirect
        $ajax = new Ajax();
        $request->session()->flash(FlashMessageViewComposer::MESSAGE_SUCCESS, 'Yeni Ayar oluşturuldu.');

        return $ajax->redirect(route('settings.index'));
    }

    public function destroy($settingId)
    {
        $setting = GaravelSettingModel::find($settingId);
        if (!$setting || $setting->is_changeable == 0)
        {
            abort(404);
        }

        $setting->delete();
        $ajax = new Ajax();
        request()->session()->flash(FlashMessageViewComposer::MESSAGE_SUCCESS, 'Ayar silindi.');

        return $ajax->redirect(route('settings.index'));
    }


    public function indexDataTable(Request $request)
    {
        if ($request->ajax())
        {
            $settings = GaravelSettingModel::orderBy('key', 'asc');

            return datatables()->eloquent($settings)
                ->setTransformer(new SettingListTransformer())
                ->toJson();
        }

    }


}
