<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaariAjaxController extends Controller
{

    public function bariPublishStatus(Request $request)
    {
        if ($request->ajax()) {
            switch ($request->statustext) {

                case $request->statustext=='Breaking News':
                    $model = strripos($request->statustext, ' ')+1;
                    $test = 'App\Models\\' . substr($request->statustext,$model);
                    $update= ['breaking_news'=>$request->status];
                    break;

                case $request->statustext:
                    $test = 'App\Models\\' . $request->statustext;
                    $update= ['status'=>$request->status];
                    break;

            }
            $test::where('id',$request->id)->update($update);

            return $request;
        }
    }
}
