<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\PlanSetting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class BaariPlanController extends Controller
{
    public function __construct()
    {
       /*  $this->middleware('permission:plans-create')->only('create', 'store');
        $this->middleware('permission:plans-read')->only('index');
        $this->middleware('permission:plans-update')->only('edit', 'update','status');
        $this->middleware('permission:plans-delete')->only('destroy','deleteAll'); */
    }

    public function index()
    {
        $plans = Plan::latest()->get();
        $plan_settings = PlanSetting::latest()->get();
        return view('author.plans.index', $plan_settings, compact('plans', 'plan_settings'));
    }

    public function create()
    {
        $roles = Role::where('name', '!=', 'author')->get();
        return view('author.plans.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'price' => 'required|numeric|min:0|max:9999999999999',
            'discount' => 'nullable|numeric|min:0|max:100',
            'duration' => 'nullable|numeric|min:0|max:11',
            'duration_type' => 'nullable|in:monthly,yearly,lifetime',
            'features' => 'nullable|array',
        ]);

        // Calculate the price based on discount type
        $salesPrice = 0;
        if ($request->discount <= 100) {
            $price = floatval($request->input('price', 0));
            $discount = floatval($request->input('discount', 0));
            $discountAmount = $price * ($discount / 100);
            $salesPrice = $price - $discountAmount;

        } else {
            return response()->json('Discount cannot be more than the 100!', 403);
        }

        $featuresData = [];
        foreach ($request->input('features', []) as $feature) {
            $featuresData[] = [
                'name'  => $feature['name'][0] ?? '',
                'details'  => $feature['details'][0] ?? '',
                'status' => isset($feature['status'][0]) ? 1 : 0,
            ];
        }

        $duration = ($request->duration_type === 'monthly' || $request->duration_type === 'yearly') && $request->duration === null ? 1 : $request->duration;

        Plan::create($request->except('duration','features') + [
                'sales_price' => $salesPrice,
                'duration' => $duration,
                'features'    => $featuresData,
                'creator_id'  => auth()->id(),
            ]);

        return response()->json([
            'message' => __('Subscription Plan created successfully'),
            'redirect' => route('author.plans.index')
        ]);

    }


    public function edit(Plan $plan)
    {
        $roles = Role::where('name', '!=', 'author')->get();
        return view('author.plans.edit', compact('roles', 'plan'));
    }


    public function update(Request $request, Plan $plan)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'price' => 'required|numeric|min:0|max:9999999999999',
            'discount' => 'nullable|numeric|min:0|max:100',
            'duration' => 'nullable|numeric|min:0|max:11',
            'duration_type' => 'nullable|in:monthly,yearly,lifetime',
            'features' => 'nullable|array',
        ]);

        // Calculate the price based on discount type
        $salesPrice = 0;
        if ($request->discount <= 100) {
            $price = floatval($request->input('price', 0));
            $discount = floatval($request->input('discount', 0));
            $discountAmount = $price * ($discount / 100);
            $salesPrice = $price - $discountAmount;

        } else {
            return response()->json('Discount cannot be more than the 100!', 403);
        }

        $featuresData = [];
        foreach ($request->input('features', []) as $feature) {
            $featuresData[] = [
                'name'  => $feature['name'][0] ?? '',
                'details'  => $feature['details'][0] ?? '',
                'status' => isset($feature['status'][0]) ? 1 : 0,
            ];
        }
        if (($request->duration_type=='monthly'||$request->duration_type=='yearly') && $request->duration==null){
            $duration =1 ;
        }else{
            $duration = $request->duration;
        }

        $plan->update($request->except('duration','features') + [
                'sales_price' => $salesPrice,
                'duration'    => $duration,
                'features'    => $featuresData,
                'creator_id'  => auth()->id(),
                'status' => 'updated',
            ]);

        return response()->json([
            'message' => __('Subscription Plan updated successfully'),
            'redirect' => route('author.plans.index')
        ]);

    }

    public function destroy(Plan $plan)
    {
        $plan->delete();
        return response()->json([
            'message'   => __('Subscription Plan deleted successfully'),
            'redirect'  => route('author.plans.index')
        ]);
    }

    public function deleteAll(Request $request)
    {
        Plan::whereIn('id', $request->ids)->delete();
        return response()->json([
            'message' => __('Subscription plan deleted successfully'),
            'redirect' => route('author.plans.index')
        ]);
    }
}
