<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Business;
use App\Models\Category;
use App\Models\CreditsEarning;
use App\Models\Faq;
use App\Models\Generate;
use App\Models\Plan;
use App\Models\Subscribe;
use App\Models\Suggestion;
use App\Models\User;

class DashboardController extends Controller
{

    public function __construct()
    {
       //$this->middleware('permission:dashboard-read')->only('index');
    }

    public function index()
    {
        $users = User::whereRole('user')->latest()->take(5)->get();
        return view('author.dashboard.index', compact('users'));
    }

    public function getDashboardData()
    {
        $data['app_new_user'] = Business::withCount('subscriptions')
            ->having('subscriptions_count', '<', 2)->count();
       // $data['app_expired_shop'] =Business::withCount('subscriptions')
           // ->having('subscriptions_count', '<', 2)->count();
        $data['app_expired_shop'] = Business::withCount(['subscriptions' => function ($query) {
            $query->where('status', 0);
        }])
            ->having('subscriptions_count', '<', 1)
            ->count();
//        $data['subscription'] = Plan::count();
//        $data['free_subscribers'] = Subscribe::where('price', '<=', 0)->count();
//        $data['category'] = Category::count();
//        $data['subscribers'] = Subscribe::count();
//        $data['banner'] = Banner::count();
//        $data['faqs'] = Faq::count();
//        $data['suggestions'] = Suggestion::count();
//        $data['credit'] = CreditsEarning::sum('credits');
//        $data['cost_credits'] = Generate::sum('cost_credits');

        return response()->json($data);

    }

//    public function yearlyGenerates()
//    {
//        $data['texts'] = Generate::whereType('text')
//                            ->whereYear('created_at', request('year') ?? date('Y'))
//                            ->selectRaw('MONTHNAME(created_at) as month, COUNT(*) as total_items')
//                            ->groupBy('month')
//                            ->get();
//
//        $data['images'] = Generate::whereType('image')
//                            ->whereYear('created_at', request('year') ?? date('Y'))
//                            ->selectRaw('MONTHNAME(created_at) as month, COUNT(*) as total_items')
//                            ->orderBy('month')
//                            ->groupBy('month')
//                            ->get();
//
//        return response()->json($data);
//    }

    public function userOverview()
    {
        $data['subscription'] = User::whereYear('created_at', request('year') ?? date('Y'))->whereNotNull('plan_id')->count(); // subscribed_user
        $data['free_user'] = User::whereYear('created_at', request('year') ?? date('Y'))->whereRole('user')->whereNull('plan_id')->count();

        return response()->json($data);
    }
}
