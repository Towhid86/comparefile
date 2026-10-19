<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\BusinessCategory;
use Illuminate\Http\Request;

class BaariBusinessCategoryController extends Controller
{
    public function index()
    {
        $business_categories = BusinessCategory::latest()->paginate(10);
        return view('author.business-categories.index',compact('business_categories'));
    }

    public function create(){
        return view('author.business-categories.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name'          => 'required|string|unique:business_categories|max:255',
            'description'   => 'nullable|string|max:255',
            'status'        => 'in:on',
        ]);

        BusinessCategory::create($request->except('status','_token') + [
                'status' => $request->status ? 1 : 0,
            ]);

        return response()->json([
            'message'   => __('Category saved successfully'),
            'redirect'  => route('author.business-categories.index')
        ]);

    }

    public function edit($id)
    {
        $category = BusinessCategory::find($id);
        return view('author.business-categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:business_categories,name,'.$id,
            'description' => 'nullable|string|max:255',
            'status'      => 'in:on',
        ]);

        $category = BusinessCategory::find($id);

        $category->update($request->except('status') + [
                'status' => $request->status ? 1 : 0,
            ]);

        return response()->json([
            'message'   => __('Category updated successfully'),
            'redirect'  => route('author.business-categories.index')
        ]);
    }

    public function destroy($id)
    {
        $category = BusinessCategory::findOrFail($id);
        $category->delete();
        return response()->json([
            'message'   => __('Category deleted successfully'),
            'redirect'  => route('author.business-categories.index')
        ]);
    }

    public function deleteAll(Request $request)
    {
        BusinessCategory::whereIn('id', $request->ids)->delete();

        return response()->json([
            'message'   => __('Category deleted successfully'),
            'redirect'  => route('author.business-categories.index')
        ]);
    }

    public function status(Request $request, $id)
    {
        $category = BusinessCategory::findOrFail($id);
        $category->update(['status' => $request->status]);
        return response()->json(['message' => 'Business category']);
    }




}
