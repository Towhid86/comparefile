<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Models\Language;

class LocaleBaariController extends Controller
{
    public function setLocale($lang)
    {
       /*  $languages = Language::get();
        if(in_array($lang,['en','bn','ar','fr','de','es'])) {
            App::setLocale($lang);
            Session::put('locale', $lang);

        }

        return back(); */
        $language = cache()->remember("language_{$lang}", 60*60, function () use ($lang) {
            return Language::where('alias', $lang)->where('status', '1')->first();
        });

        if ($language) {
            App::setLocale($lang);
            Session::put('locale', $lang);
            Session::put('direction', $language->direction);
        }

        return back();
    }
}
