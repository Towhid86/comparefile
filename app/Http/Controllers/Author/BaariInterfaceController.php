<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\WebInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Helpers\HasUploader;

class BaariInterfaceController extends Controller
{

    use HasUploader;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $interfaces = WebInterface::latest()->paginate(10);
        return view('author.web-setting.interfaces.index', compact('interfaces'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('author.web-setting.interfaces.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        WebInterface::create($request->except('image') + [
            'image' => $request->image ? $this->upload($request, 'image') : NULL
        ]);

        return response()->json([
            'message' => __('Interfaces created successfully'),
            'redirect' => route('author.interfaces.index')
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
        $interface = WebInterface::findOrFail($id);
        return view('author.web-setting.interfaces.edit', compact('interface'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $interface = WebInterface::findOrFail($id);
        $request->validate([
            'status' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $interface->update($request->except('image') + [
            'image' => $request->image ? $this->upload($request, 'image', $interface->image) : $interface->image,
        ]);

        return response()->json([
            'message' => __('Interface updated successfully'),
            'redirect' => route('author.interfaces.index')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $posAppInterface = WebInterface::findOrFail($id);
        if (file_exists($posAppInterface->image)) {
            Storage::delete($posAppInterface->image);
        }
        $posAppInterface->delete();

        return response()->json([
            'message'   => __('Interface deleted successfully'),
            'redirect'  => route('author.interfaces.index')
        ]);
    }

    public function status(Request $request, $id)
    {
        $posAppInterface = WebInterface::findOrFail($id);
        $posAppInterface->update(['status' => $request->status]);
        return response()->json(['message' => 'Interface ']);
    }

    public function deleteAll(Request $request)
    {
        $posAppInterfaces = WebInterface::whereIn('id', $request->ids)->get();
        foreach ($posAppInterfaces as $posAppInterface) {
            if (file_exists($posAppInterface->image)) {
                Storage::delete($posAppInterface->image);
            }
        }

        $posAppInterfaces->each->delete();

        return response()->json([
            'message' => __('Selected Interface deleted successfully'),
            'redirect' => route('author.interfaces.index')
        ]);
    }
}
