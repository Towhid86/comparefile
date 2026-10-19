<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Option;
use Illuminate\Http\Request;

class BaariAnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $announcements = Option::where('key','announcements')->latest()->get();
        return view('author.pages.announcement.index',compact('announcements'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'     =>'required|string',
            'version'   =>'nullable|string',
            'date'      =>'required|date',
            'category'  =>'required|string',
            'message'   =>'required|string',
        ]);

        Option::create([
            'key' => 'announcements',
            'value' => $request->except('_token'),
        ]);

        return response()->json([
            'message'=> __('Announcement saved successfully'),
            'redirect'=> route('authorannouncements.index')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $announcement = Option::findOrFail($id);
        return response()->json($announcement->value);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $announcement = Option::findOrFail($id);
        return response()->json($announcement->value);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'     =>'required|string',
            'version'   =>'nullable|string',
            'date'      =>'required|date',
            'category'  =>'required|string',
            'message'   =>'required|string',
        ]);

        $announcement = Option::findOrFail($id);
        $announcement->update([
            'value' => $request->except('_token', '_method')
        ]);

        return response()->json([
            'message'   => __('Announcement updated successfully'),
            'redirect'  => route('authorannouncements.index')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $announcement = Option::findOrFail($id);
        $announcement->delete();
        return response()->json([
            'message'   => __('Announcement deleted successfully'),
            'redirect'  => route('authorannouncements.index')
        ]);
    }

    public function status(Request $request, $id)
    {
        $announcement = Option::findOrFail($id);
        $announcement->update(['status' => $request->status]);
        return response()->json(['message' => 'Announcement']);
    }
}
