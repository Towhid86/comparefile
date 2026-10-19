<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use Illuminate\Support\Facades\Cache;

class BaariCountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countries = Country::latest()->paginate(10);
        return view('author.countries.index',compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'nick_name' => 'required|string|max:100',
            'iso_code' => 'nullable|string|max:100',
            'alpha2_code' => 'nullable|string|max:100',
            'alpha3_code' => 'nullable|string|max:100',
            'phone_code' => 'nullable|string|max:100',

        ]);

        Country::create($request->except('_token'));

        return response()->json([
            'message'   => __('Country created successfully'),
            'redirect'  => route('author.countries.index')
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'nick_name' => 'required|string|max:100',
            'iso_code' => 'nullable|string|max:100',
            'alpha2_code' => 'nullable|string|max:100',
            'alpha3_code' => 'nullable|string|max:100',
            'phone_code' => 'nullable|string|max:100',

        ]);

        $country = Country::findOrFail($id);
        $country->update($request->except('_token()'));

        Cache::forget('countries');

        return response()->json([
            'message'   => __('Country updated successfully'),
            'redirect'  => route('author.countries.index')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Country::findOrFail($id)->delete();
        return response()->json([
            'message'   => __('Country deleted successfully'),
            'redirect'  => route('author.countries.index')
        ]);
    }
}
