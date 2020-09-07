<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Setting;

class SettingController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $settings = [];

        $dbsettings = Setting::get();

        foreach ($dbsettings as $s) {
            $settings[$s['name']] = $s['content'];
        }

        return view('admin.settings.index', [
            'settings' => $settings
        ]);
    }

    public function save(Request $request)
    {
        $data = $request->only([
            'title',
            'subtitle',
            'email',
            'bgcolor',
            'textcolor'
        ]);

        $validator = $this->validator($data);

        if ($validator->fails()) {
            return redirect()->route('settings')
                ->withErrors($validator);
        }

        foreach ($data as $key => $value) {
            Setting::where('name', $key)->update([
                'content' => $value
            ]);
        }

        return redirect()->route('settings')
            ->with('warning', 'Informações alteradas com sucesso!');;
    }

    protected function validator($data) {
        return Validator::make($data, [
            'title' => ['string', 'max:100'],
            'subtitle' => ['string', 'max:100'],
            'email' => ['string', 'email'],
            'bgcolor' => ['string', 'regex:/#[a-zA-Z0-9]{6}/i'],
            'textcolor' => ['string', 'regex:/#[a-zA-Z0-9]{6}/i']
        ]);
    }
}
