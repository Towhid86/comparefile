<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BaariAboutController extends Controller
{
    public function __construct()
    {
       
    }

    public function index()
    {
        $about = Option::where('key','about')->first();

        return view('author.about-us.index', compact('about'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'about' => 'required|string'
        ]);

        Option::updateOrCreate(
            ['key' => 'about'],
            ['value' => $request->about]
        );

        cache::forget('about');

        return response()->json(__('About us updated successfully.'));
    }
}
