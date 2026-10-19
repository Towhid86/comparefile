<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BaariBlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::latest()->paginate(10);
        return view('author.web-setting.blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('author.web-setting.blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'             => 'required|unique:blogs,title',
            'image'             => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'status'            => 'boolean',
            'descriptions'      => 'nullable|string',
            'tags'              => 'nullable|array',
            'meta.title'        => 'nullable|string',
            'meta.description'  => 'nullable|string',
        ]);

        Blog::create($request->except('image') + [
            'user_id' => Auth::id(),
            'image' => $request->image ? $this->upload($request, 'image') : null,
        ]);

        return response()->json([
            'message'   => __('BLog created successfully'),
            'redirect'  => route('author.blogs.index')
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
        return view('author.web-setting.blogs.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'title'             => 'required|unique:blogs,title,' . $blog->id,
            'image'             => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'status'            => 'boolean',
            'descriptions'      => 'nullable|string',
            'tags'              => 'nullable|array',
            'meta.title'        => 'nullable|string',
            'meta.description'  => 'nullable|string',
        ]);

        $blog->update($request->except('image') + [
            'user_id' => Auth::id(),
            'image' => $request->image ? $this->upload($request, 'image', $blog->image) : $blog->image,
        ]);

        return response()->json([
            'message'   => __('BLog updated successfully'),
            'redirect'  => route('author.blogs.index')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (file_exists($blog->image)) {
            Storage::delete($blog->image);
        }

        $blog->delete();

        return response()->json([
            'message' => __('Blog deleted successfully'),
            'redirect' => route('author.blogs.index')
        ]);
    }

    public function baariFilter()
    {
        $blogs  = Blog::when(request('search'), function ($q) {
            $q->where('title', 'like', '%' . request('search') . '%');
        })

            ->latest()
            ->paginate(request()->per_page ?? 25);

        return response()->json([
            'data' => view('author.web-setting.blogs.datas', compact('blogs'))->render()
        ]);
    }

    public function status(Request $request, $id)
    {
        $blog_status = Blog::findOrFail($id);
        $blog_status->update(['status' => $request->status]);
        return response()->json(['message' => 'Blog']);
    }

    public function deleteAll(Request $request)
    {
        Blog::whereIn('id', $request->ids)->delete();
        return response()->json([
            'message' => __('Selected Blog deleted successfully'),
            'redirect' => route('author.blogs.index')
        ]);
    }

    public function filterComment($id)
    {
        $blog = Blog::findOrFail($id);
        $comments = Comment::with('blog:id')->whereStatus(1)->where('blog_id', $blog->id)->latest()->paginate(10);
        return view('author.web-setting.blogs.comments.index', compact('comments'));
    }
}
