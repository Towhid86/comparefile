<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\BusinessCategory;
use App\Models\Country;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class BaariBusinessController extends Controller
{
    public function __construct()
    {
        /* $this->middleware('permission:business-create')->only('create', 'store');
        $this->middleware('permission:business-read')->only('index');
        $this->middleware('permission:business-update')->only('edit', 'update','status');
        $this->middleware('permission:business-delete')->only('destroy','deleteAll'); */
    }
     public static function middleware() : array
    {
        return[
            'role_or_permission:manager|edit articles',
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission:business-create'),only:['create', 'store'])
        ];
    }

    public function index()
    {
        $businesses  = Business::with('user','plan','businessCategory')->latest()->paginate(10);
        return view('author.business.index',compact('businesses'));
    }

    public function create()
    {
        $business_categories = BusinessCategory::where('status',1)->latest()->get();
        $countries           = Country::where('status',1)->get();
        $roles               = Role::where('name', '!=', 'Author')->latest()->get();
        $plans               = Plan::latest()->get();
        return view('author.business.create', compact('business_categories','countries', 'roles', 'plans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'plan_id'               => 'required|exists:plans,id',
            'name'                  => 'required|string|max:255',
            'role'                  => 'required|string',
            'email'                 => 'required|unique:users|email',
            'phone'                 => 'nullable|unique:users|string|max:30',
            'gender'                => 'nullable|string|max:255',
            'password'              => 'required|string|min:6|confirmed',
            'business_address'      => 'nullable|string|max:255',
            'country_id'            => 'nullable|exists:countries,id',
            'image'                 => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'business_category_id'  => 'required|integer',
            'business_name'         => 'required|string|max:255',
            'balance'               => 'nullable|numeric|min:0',
            'lang'                  => 'nullable|string',
            'is_owner'              => 'nullable|boolean',
            'is_access'             => 'nullable|boolean',
            'status'                => 'nullable|integer',
        ]);

        DB::beginTransaction();

        try {
            $data = $request->only('name','country_id', 'role', 'email', 'phone', 'status');
            $data['password'] = Hash::make($request->password);

            if($request->image){
                $data['image'] = imageUpload($request->file('image'),'users');
            }
            $user = User::create($data);

            $data_business=[
                'user_id'               => $user->id,
                'plan_id'               => $request->plan_id,
                'business_category_id'  => $request->business_category_id,
                'name'                  => $request->business_name,
                'business_address'      => $request->business_address,
                'balance'               => $request->balance ?? 0,
                'status'                => $request->status ? 1 : 0,
            ];
            $user->business()->create($data_business);

            DB::commit();

            return response()->json([
                'message'   => __('User saved successfully'),
                'redirect'  => route('author.business.index')
            ]);
        }catch (\Exception $e){
            DB::rollBack();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $business_categories = BusinessCategory::where('status',1)->latest()->get();
        $plans               = Plan::latest()->get();
        $countries           = Country::where('status',1)->get();
        $roles               = Role::where('name', '!=', 'Author')->latest()->get();
        $business            = Business::with('user','plan','businessCategory')->findOrFail($id);

        return view('author.business.edit', compact('business_categories','plans','countries', 'roles', 'business'));
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
        $business = Business::findOrFail($id);

        $request->validate([
            'plan_id'               => 'required|exists:plans,id',
            'name'                  => 'required|string|max:255',
            'role'                  => 'required|string',
            'email'                 => 'required|email|unique:users,email,' . $business->user->id,
            'phone'                 => 'nullable|string|max:30|unique:users,phone,' . $business->user->id,
            'gender'                => 'nullable|string|max:255',
            'password'              => 'nullable|string|min:6|confirmed',
            'business_address'      => 'nullable|string|max:255',
            'country_id'            => 'nullable|exists:countries,id',
            'image'                 => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'business_category_id'  => 'required|integer',
            'business_name'         => 'required|string|max:255',
            'balance'               => 'nullable|numeric|min:0',
            'lang'                  => 'nullable|string',
            'is_owner'              => 'nullable|boolean',
            'is_access'             => 'nullable|boolean',
            'status'                => 'nullable|integer',
        ]);

        DB::beginTransaction();

        try {

             $data_business=[
                 'user_id'               => $business->user->id,
                 'plan_id'               => $request->plan_id,
                 'business_category_id'  => $request->business_category_id,
                 'name'                  => $request->business_name,
                 'business_address'      => $request->business_address,
                 'balance'               => $request->balance ?? 0,
                 'status'                => $request->status ? 1 : 0,
             ];
            $data_user['password'] = Hash::make($request->password);

            if($request->image){
                $data_user['image'] = imageUpload($request->file('image'),'users',$request->image);
            }

            $business->update($data_business);

            $data_user=[
                'name' => $request->name,
                'country_id' => $request->country_id,
                'role' => $request->role,
                'email' => $request->email,
                'phone' => $request->phone,
                'status'  => 1,
            ];

            $business->user()->update($data_user);

            DB::commit();

            return response()->json([
                'message'   => __('Data updated successfully'),
                'redirect'  => route('author.business.index')
            ]);
        }catch (\Exception $e){
            DB::rollBack();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        uploadImageDelete(ltrim($user->image,'storage/'));

        $user->delete();
        return response()->json([
            'message'   => __('Data deleted successfully'),
            'redirect'  => route('author.business.index')
        ]);
    }

    public function status(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => $request->status]);
        return response()->json(['message' => 'User']);
    }

    public function deleteAll(Request $request)
    {
        $idsToDelete = $request->input('ids');

        $users = User::whereIn('id', $idsToDelete)->get();
        foreach ($users as $user) {
            uploadImageDelete(ltrim($user->image,'storage/'));
        }

        User::whereIn('id', $idsToDelete)->delete();

        return response()->json([
            'message' => __('User deleted successfully'),
            'redirect'  => route('author.business.index')
        ]);
    }

}
