<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Helpers\HasUploader;

class BaariDesignController extends Controller
{
    use HasUploader;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $designs = Option::where('key', 'designs')->latest()->paginate(10);
        return view('author.web-setting.designs.index', compact('designs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('author.web-setting.designs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required|in:0,1',
            'image' => 'required|image|max:2048',
        ]);

        Option::create([
            'key' => 'designs',
            'value' => $request->except('_token', '_method', 'status', 'image') + [
                'image' => $request->image ? $this->upload($request, 'image') : NULL
            ],
            'status' => request('status')
        ]);

        return response()->json([
            'message'   => __('author Design Created successfully'),
            'redirect'  => route('author.designs.index')
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
        $design = Option::findOrFail($id);
        return view('author.web-setting.designs.edit', compact('design'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'nullable',
            'image' => 'nullable|image|max:2048',
        ]);

        $design = Option::findOrFail($id);
        Cache::forget($design->key);
        $design->update([
            'key' => 'designs',
            'value' => $request->except('_token', '_method', 'status', 'image') + [
                'image' => $request->image ? $this->upload($request, 'image') : $design->value['image']
            ],
            'status' => request('status')
        ]);

        return response()->json([
            'message'   => __('Design updated successfully'),
            'redirect'  => route('author.designs.index')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    { {
            $option = Option::findOrFail($id);
            $option->delete();

            return response()->json([
                'message' => __('Design deleted successfully'),
                'redirect' => route('author.designs.index')
            ]);
        }
    }

    public function status(Request $request, $id)
    {
        $design = Option::findOrFail($id);
        $design->update(['status' => $request->status]);
        return response()->json(['message' => 'Design']);
    }


    public function deleteAll(Request $request)
    {

        $idsToDelete = $request->input('ids');
        $options = Option::whereIn('id', $idsToDelete)->get();

        foreach ($options as $option) {
            $option->delete();
        }

        return response()->json([
            'message' => __('Selected Design deleted successfully'),
            'redirect' => route('author.designs.index')
        ]);
    }
}
