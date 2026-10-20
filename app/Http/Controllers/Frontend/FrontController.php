<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontController extends Controller
{
        public function check()
        {
            $followers = json_decode(
                file_get_contents(storage_path('app/followers1.json')),
                true
            );

            $following = json_decode(
                file_get_contents(storage_path('app/following1.json')),
                true
            );

                    // Extract names
                    $followerNames = collect($followers['followers_v3'] ?? [])
                ->pluck('name');
                $followingNames = collect($following['following_v3'] ?? [])
                ->pluck('name');

                    // Find names not in followers
                    // People you follow but who don't follow you back
            $notFollowingBack = $followingNames
                ->diff($followerNames)
                ->values();
            dd($notFollowingBack);
        }
}
