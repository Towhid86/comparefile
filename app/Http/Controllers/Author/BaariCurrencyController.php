<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BaariCurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $currencies = Currency::orderBy('default', 'desc')->orderBy('status', 'desc')->latest()->paginate(10);
        return view('author.currencies.index', compact('currencies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('author.currencies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:currencies',
            'iso_code' => 'required|string|unique:currencies',
            'rate' => 'nullable|numeric',
            'symbol' => 'nullable|string',
            'position' => 'nullable|string',
            'status' => 'required|integer',
            'default' => 'nullable|boolean',
        ]);

        Currency::create($request->all());
        Cache::forget('default_currency');

        return response()->json([
            'message'   => __('Currency updated successfully'),
            'redirect'  => route('author.currencies.index')
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
        return view('author.currencies.edit', compact('currency'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|unique:currencies,name,' . $currency->id,
            'iso_code' => 'required|string|unique:currencies,iso_code,' . $currency->id,
            'rate' => 'nullable|numeric',
            'symbol' => 'nullable|string',
            'position' => 'nullable|string',
            'status' => 'required|integer',
            'default' => 'nullable|boolean',
        ]);

        $currency->update($request->all());
        Cache::forget('default_currency');

        return response()->json([
            'message'   => __('Currency updated successfully'),
            'redirect'  => route('author.currencies.index')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function baariFilter()
    {
        $currencies  = Currency::orderBy('default', 'desc')->orderBy('status', 'desc')->when(request('search'), function ($q) {
            $q->where('name', 'like', '%' . request('search') . '%');
        })
            ->latest()
            ->paginate(request()->per_page ?? 25);

        return response()->json([
            'data' => view('author.currencies.datas', compact('currencies'))->render()
        ]);
    }

    public function status(Request $request, $id)
    {
        $currency = Currency::findOrFail($id);
        $currency->update(['status' => $request->status]);
        return response()->json(['message' => 'Currency']);
    }

    public function default($id)
    {
        $currency = Currency::find($id);

        if ($currency) {
            Currency::where('id', '!=', $id)->update(['default' => 0]);
            $currency->update(['default' => 1]);
        }

        Cache::forget('default_currency');
        return redirect()->route('author.currencies.index')->with('message', __('Default currency activated successfully'));
    }
}
