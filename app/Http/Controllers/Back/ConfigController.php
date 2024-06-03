<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Config;

class ConfigController extends Controller
{
    public function index(){
        $config=Config::find(1);
        return view('back.config.index', compact('config'));
    }

    public function update(Request $request){
        $config = Config::find(1);

        if ($request->filled('title')) {
            $config->title = $request->title;
        }

        $config->active = $request->active;
        $config->facebook = $request->facebook;
        $config->twitter = $request->twitter;
        $config->linkedin = $request->linkedin;
        $config->github = $request->github;
        $config->youtube = $request->youtube;
        $config->instagram = $request->instagram;

        if ($request->hasFile('logo')) {
            $titleSlug = Str::slug(isset($config->title) ? $config->title : 'default') . '-logo';
            $extension = $request->logo->getClientOriginalExtension();
            $logo = $titleSlug . '.' . $extension;
            $request->logo->move(public_path('uploads'), $logo);
            $config->logo = 'uploads/' . $logo;
        }

        if ($request->hasFile('favicon')) {
            $titleSlug = Str::slug(isset($config->title) ? $config->title : 'default') . '-favicon';
            $extension = $request->favicon->getClientOriginalExtension();
            $favicon = $titleSlug . '.' . $extension;
            $request->favicon->move(public_path('uploads'), $favicon);
            $config->favicon = 'uploads/' . $favicon;
        }

        $config->save();
        toastr()->success('Başarılı', 'Ayarlar başarıyla güncellendi!');
        return redirect()->back();
    }

}
