<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\PlanSetting;
use Illuminate\Http\Request;

class BaariPlanSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'plan_id' => 'required|exists:plans,id|unique:plan_settings,plan_id',
            'title' => 'required|string|max:255',
        ]);

        PlanSetting::create($request->all());

        return response()->json([
            'message'   => __('Plan highlighted successfully'),
            'redirect'  => route('author.plans.index')
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(PlanSetting $planSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PlanSetting $planSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PlanSetting $planSetting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PlanSetting $planSetting)
    {
        //
    }
}
