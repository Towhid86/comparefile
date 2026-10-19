<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\Request;

class BaariFeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $features = Feature::latest()->paginate(10);
        return view('author.web-setting.features.index', compact('features'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('author.web-setting.features.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required',
            'title' => 'required',
            'bg_color' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        Feature::create($request->except('image') + [
            'image' => $request->image ? $this->upload($request, 'image') : NULL
        ]);

        return response()->json([
            'message' => __('Feature created successfully'),
            'redirect' => route('author.features.index')
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
        return view('author.web-setting.features.edit', compact('feature'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required',
            'title' => 'required|string',
            'bg_color' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $feature->update($request->except('image') + [
            'image' => $request->image ? $this->upload($request, 'image', $feature->image) : $feature->image,
        ]);

        return response()->json([
            'message' => __('Feature updated successfully'),
            'redirect' => route('author.features.index')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (file_exists($feature->image)) {
            Storage::delete($feature->image);
        }
        $feature->delete();

        return response()->json([
            'message'   => __('Feature deleted successfully'),
            'redirect'  => route('author.features.index')
        ]);
    }

    public function status(Request $request, $id)
    {
        $feature = Feature::findOrFail($id);
        $feature->update(['status' => $request->status]);
        return response()->json(['message' => 'Feature ']);
    }


    public function deleteAll(Request $request)
    {
        $features = Feature::whereIn('id', $request->ids)->get();
        foreach ($features as $feature) {
            if (file_exists($feature->image)) {
                Storage::delete($feature->image);
            }
        }

        $features->each->delete();

        return response()->json([
            'message' => __('Selected Feature deleted successfully'),
            'redirect' => route('author.features.index')
        ]);
    }

    public function baariFilter()
    {
        $features = Feature::when(request('status') != null, function ($query) {
            $query->where('status', request('status'));
        })->when(request('search'), function ($q) {
            $q->where('title', 'like', '%' . request('search') . '%');
        })

            ->latest()
            ->paginate(request()->per_page ?? 25);

        return response()->json([
            'data' => view('author.web-setting.features.datas', compact('features'))->render()
        ]);
    }
}
