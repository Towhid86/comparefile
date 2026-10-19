<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\BusinessCategory;
use App\Models\Tutorial;
use Illuminate\Http\Request;

class BaariTutorialController extends Controller
{

    public function index()
    {
        $tutorials = Tutorial::latest()->paginate(10);
        return view('author.tutorials.index',compact('tutorials'));
    }

    public function create()
    {
        return view('author.tutorials.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string|max:255',
            'thumbnail'    => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status'       => 'nullable|in:on',
            'video'        => 'required|file|mimetypes:video/mp4,video/mkv,video/webm,video/3gpp|max:512000',
        ]);

        $data = [];

        if($request->thumbnail){
            $data['thumbnail'] = imageUpload($request->file('thumbnail'),'tutorials');
        }
        if($request->video){
            $data['video'] = imageUpload($request->file('video'),'tutorials');
        }
        $data['status'] = $request->status ? 1 : 0;

        Tutorial::create(array_merge($request->except(['_token', 'thumbnail', 'video', 'status']), $data));

        return response()->json([
            'message'   => __('Tutorial created successfully'),
            'redirect'  => route('author.tutorials.index')
        ]);

    }

    public function edit(Tutorial $tutorial)
    {
        return view('author.tutorials.edit', compact('tutorial'));
    }

    public function update(Request $request, Tutorial $tutorial)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string|max:255',
            'thumbnail'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status'       => 'nullable|in:on',
            'video'        => 'nullable|file|mimetypes:video/mp4,video/mkv,video/webm,video/3gpp|max:512000',
        ]);

        $data = [];

        if ($request->has('thumbnail')){
            $data['thumbnail'] = imageUpload($request->file('thumbnail'),'tutorials', $request->thumbnail);
        }

        if($request->video){
            $data['video'] = imageUpload($request->file('video'),'tutorials', $request->video);
        }
        $data['status'] = $request->status ? 1 : 0;

        $tutorial->update(array_merge($request->except(['_token', 'thumbnail', 'video', 'status']), $data));

        return response()->json([
            'message'   => __('Tutorial updated successfully'),
            'redirect'  => route('author.tutorials.index')
        ]);
    }


    public function destroy(Tutorial $tutorial)
    {
        $tutorial->delete();
        return response()->json([
            'message'   => __('Category deleted successfully'),
            'redirect'  => route('author.tutorials.index')
        ]);
    }

    public function deleteAll(Request $request)
    {
        Tutorial::whereIn('id', $request->ids)->delete();

        return response()->json([
            'message'   => __('Category deleted successfully'),
            'redirect'  => route('author.tutorials.index')
        ]);
    }

    public function status(Request $request, $id)
    {
        $tutorial = Tutorial::findOrFail($id);
        $tutorial->update(['status' => $request->status]);
        return response()->json(['message' => 'Business category']);
    }

}
