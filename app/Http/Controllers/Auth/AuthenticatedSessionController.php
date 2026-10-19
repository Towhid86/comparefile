<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;

class AuthenticatedSessionController extends Controller
{
      /**
     * Display the login view.
     */
    public function create(Request $request)//: View
    {
        return view('auth.login',[
        'remembered_email' => $request->cookie('remembered_email'),
        'remembered_password' => $request->cookie('remembered_password')
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */

    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();
        $user = auth()->user();
        $roleName = $user->getRoleNames()->first();

    // If no role found → logout
    if (!$roleName) {
        Auth::logout();
        return response()->json([
            'message' => __('No role assigned to this user.'),
            'redirect' => route('login'),
        ], 403);
    }

    // Convert role name to slug (for route name & prefix)
    $roleSlug = Str::slug($roleName); // e.g., "Super Admin" => "super-admin"
   /*  if ($roleSlug == 'super-admin') {
        $roleSlug = 'author';
    } */
    // Get permissions from role
    $role = Role::where('name', $roleName)->with('permissions:name')->first();

    $permission = $role?->permissions
        ->pluck('name')
        ->reject(fn($p) => Str::startsWith($p, 'reports-'))
        ->first();

    $page = explode('-', $permission)[0] ?? null;

    // Fallback if no valid permission found
    if (!$page) {
        auth()->logout();
        return response()->json([
            'message' => __('Invalid permissions.'),
            'redirect' => route('login'),
        ], 403);
    }

    // Build route name: e.g. "admin.users.index"
    $routeName = "{$roleSlug}.{$page}.index";

     // Fallback route if not exists
    if (!Route::has($routeName)) {
        $routeName = "{$roleSlug}.dashboard.index"; // change this if needed
    }

    // Set cookies if "remember me" is checked
    if ($request->filled('remember')) {
        Cookie::queue('remembered_email', $request->input('email'), 60);
        Cookie::queue('remembered_password', $request->input('password'), 60);
    } else {
        Cookie::queue(Cookie::forget('remembered_email'));
        Cookie::queue(Cookie::forget('remembered_password'));
    }

    // Build final redirect route
    $redirectRoute = route($roleSlug . '.dashboard.index');

    return response()->json([
        'message' => __('Logged In Successfully'),
        'remember' => $request->filled('remember') ? 1 : 0,
        'redirect' => $redirectRoute,
    ]);

      /*  $role = Role::where('name', $user->role)->with('permissions')->first();

            if (!$role || $role->permissions->isEmpty()) {
                auth()->logout();
                return response()->json('You are not authorized to access this system.', 403);
            }

            // Get first valid permission (skip 'reports-*' if it's first)
            $permission = $role->permissions
                ->pluck('name')
                ->reject(fn($p) => Str::startsWith($p, 'reports-'))
                ->first();

            $page = explode('-', $permission)[0] ?? null;

            if (!$page) {
                auth()->logout();
                return response()->json('Invalid permission format.', 403);
            }

            // Handle remember me cookies
            $request->filled('remember')
                ? Cookie::queue('remembered_email', $request->input('email'), 60)
                && Cookie::queue('remembered_password', $request->input('password'), 60)
                : Cookie::queue(Cookie::forget('remembered_email'))
                && Cookie::queue(Cookie::forget('remembered_password'));

            return response()->json([
                'message' => __('Logged In Successfully'),
                'remember' => $request->filled('remember') ? 1 : 0,
                'redirect' => route(Str::slug($role->name) . '.' . $page . '.index'),
            ]); */
    }

    /**
     * back an authenticated login request.
     */
   // public function store(Request $request)
    //{
       // Get the first role name assigned to the user (Spatie)
/* $role = $user->getRoleNames()->first();

// If no role found → logout
if (!$role) {
    Auth::logout();
    return response()->json([
        'message' => __('No role assigned to this user.'),
        'redirect' => route('login'),
    ], 403);
}

// Convert role name to slug (for route name & prefix)
$roleSlug = Str::slug($role); // e.g., "Super Admin" => "super-admin"

// Set cookies if "remember me" is checked
if ($request->filled('remember')) {
    Cookie::queue('remembered_email', $request->input('email'), 60);
    Cookie::queue('remembered_password', $request->input('password'), 60);
} else {
    Cookie::queue(Cookie::forget('remembered_email'));
    Cookie::queue(Cookie::forget('remembered_password'));
}

// Build final redirect route
$redirectRoute = route($roleSlug . '.dashboard.index');

return response()->json([
    'message' => __('Logged In Successfully'),
    'remember' => $request->filled('remember') ? 1 : 0,
    'redirect' => $redirectRoute,
]);
 */
        //$user = auth()->user();
       /*  $role = Role::where('name', $user->role)->first();


        if ($role && $role->name === $user->role) {
            $firstRole = $role->permissions->pluck('name')->first();


              if ($firstRole) {
                $page = explode('-', $firstRole);
                if ($page[0] == 'reports') {
                    $firstRole = $role->permissions->pluck('name')->get(1);
                    $page = explode('-', $firstRole);
                }
                //return  $role->name .'.'. $page[0] . '.index';;
                if ($request->filled('remember')) {
                    Cookie::queue('remembered_email', $request->input('email'), 60);
                    Cookie::queue('remembered_password', $request->input('password'), 60);
                }else {
                    Cookie::queue(Cookie::forget('remembered_email'));
                    Cookie::queue(Cookie::forget('remembered_password'));
                }
               // return $role->name;
                //return redirect()->route($role->name .'.'. $page[0] . '.index');
                return response()->json([
                    'message' => __('Loggde In Successfully'),
                    'remember' => $request->filled('remember') ? 1 : 0,
                    'redirect' => route($role->name .'.'. $page[0] . '.index'),
                ]);
            }
        } else {
            auth()->logout();

            return response()->json('You are not authorized to access this system.', 403);
        } */
   // }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
