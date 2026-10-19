<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BaariTestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $testimonials = Testimonial::latest()->paginate(10);
        return view('author.testimonials.index',compact('testimonials'));
    }

    public function baariFilter()
    {
        $testimonials  = Testimonial::when(request('search'), function ($q) {
            $q->where('name', 'like', '%' . request('search') . '%')
                ->orWhere('work_at', 'like', '%' . request('search') . '%');
        })

            ->latest()
            ->paginate(request()->per_page ?? 25);

        return response()->json([
            'data' => view('author.testimonials.datas', compact('testimonials'))->render()
        ]);
    }

    public function create()
    {
        return view('author.testimonials.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'work_at' => 'nullable|string',
            //'text' => 'nullable|string',
            'star' => 'nullable|integer',
            'status' => 'required|in:0,1',
            'name' => 'required|string',
            'image' => 'nullable|image|max:100',
        ]);

        Testimonial::create($request->except('image') + [
                'image' => $request->image ? imageUpload($request->image, 'uploads/testimonials/') : NULL
            ]);

        return response()->json([
            'message' => __('Testimonial created successfully'),
            'redirect' => route('author.testimonials.index')
        ]);
    }

    public function edit(Testimonial $testimonial)
    {
        return view('author.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'work_at' => 'nullable|string',
            'text' => 'nullable|string',
            'star' => 'nullable|integer',
            'status' => 'nullable|in:0,1',
            'name' => 'required|string',
            'image' => 'nullable|max:100',
        ]);

        $testimonial->update($request->except('image') + [
                'image' => $request->image ? imageUpload($request->image, 'uploads/testimonials/') : $testimonial->image,
            ]) ;

        return response()->json([
            'message' => __('Testimonial updated successfully'),
            'redirect' => route('author.testimonials.index')
        ]);
    }

    public function destroy(Testimonial $testimonial)
    {
        if (file_exists($testimonial->image)) {
            Storage::delete($testimonial->image);
        }
        $testimonial->delete();

        return response()->json([
            'message'   => __('Testimonial Deleted successfully'),
            'redirect'  => route('author.testimonials.index')
        ]);
    }

    public function status(Request $request,$id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->update(['status' => $request->status]);
        return response()->json(['message' => 'Testimonial ']);
    }

    public function deleteAll(Request $request)
    {
        $testimonials = Testimonial::whereIn('id', $request->ids)->get();
        foreach ($testimonials as $testimonial) {
            if (file_exists($testimonial->image)) {
                Storage::delete($testimonial->image);
            }
        }

        $testimonials->each->delete();

        return response()->json([
            'message' => __('Selected Testimonial deleted successfully'),
            'redirect' => route('author.testimonials.index')
        ]);
    }

}
