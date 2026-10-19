<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class BaariFaqController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        $faqs = Faq::latest()->paginate(10);
        return view('author.faqs.index',compact('faqs'));
    }


    public function create()
    {
        return view('author.faqs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'status' => 'nullable|in:on',
        ]);

        Faq::create($request->except('status') + [
                'status' => $request->status ? 1 : 0,
            ]);

        return response()->json([
            'message'   => __('Faqs created successfully'),
            'redirect'  => route('author.faqs.index')
        ]);
    }


    public function show(Faq $faq)
    {
        //
    }


    public function edit(Faq $faq)
    {

        return view('author.faqs.edit', compact('faq'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'status' => 'nullable|in:on',
        ]);

        $faq->update($request->except('status') + [
                'status' => $request->status ? 1 : 0,
            ]);

        return response()->json([
            'message'   => __('Faqs updated successfully'),
            'redirect'  => route('author.faqs.index')
        ]);
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        return response()->json([
            'message'   => __('Faqs deleted successfully'),
            'redirect'  => route('author.faqs.index')
        ]);
    }

    public function deleteAll(Request $request)
    {
        Faq::whereIn('id', $request->ids)->delete();

        return response()->json([
            'message'   => __('Faqs deleted successfully'),
            'redirect'  => route('author.faqs.index')
        ]);
    }

    public function status(Request $request, $id)
    {
        $Faqs = Faq::findOrFail($id);
        $Faqs->update(['status' => $request->status]);
        return response()->json(['message' => 'Faqs']);
    }
}
