<?php

namespace App\Http\Controllers\Author;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:permissions-read')->only('index','search');
        $this->middleware('permission:permissions-create')->only('store');
    }

    public function index(Request $request)
    {
        $excludedRoles = ['system admin', 'superadmin', 'author'];

        $users = User::with('roles')
            ->select('id', 'name', 'role')
            ->whereNotIn('role', $excludedRoles)
            ->orWhereNull('role')
            ->get();
        $roles = Role::whereNotIn('name', $excludedRoles)->get();

        return view('author.permissions.index', compact('roles', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'role_id' => ['required', 'exists:roles,id']
        ]);

         $user = User::findOrFail($request->input('user_id'));
        $user->update(['role' => Role::where('id', $request->input('role_id'))->value('name')]);
        $user->roles()->sync($request->input('role_id'));
        // $user->assignRole($request->input('role_id'));

        return response()->json([
            'message' => __('Role permissions assigned successfully.'),
            'redirect' => role_route('permissions.index')
        ]);
    }
    public function update(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'role_id' => ['required', 'exists:roles,id']
        ]);

         $user = User::findOrFail($request->input('user_id'));
        $user->update(['role' => Role::where('id', $request->input('role_id'))->value('name')]);
        $user->roles()->sync($request->input('role_id'));
        // $user->assignRole($request->input('role_id'));

        return response()->json([
            'message' => __('Role permissions update successfully.'),
            'redirect' => role_route('permissions.index')
        ]);
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->update(['role' => null]);
        $user->roles()->detach();

        return response()->json([
            'message' => __('Role permissions removed successfully.'),
            'redirect' => role_route('permissions.index')
        ]);
    }
}
