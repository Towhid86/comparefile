<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Customer;
use Illuminate\Http\Request;

class BaariCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $businesses  = Business::select('id','name')->where('status',1)->latest()->get();
        $customers = Customer::with('business:id,name')->latest()->paginate(10);
        return view('author.customer.index',compact('customers','businesses'));
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
           'business_id' => 'required|integer',
           'name' => 'required|string',
           'nick_name' => 'nullable|string',
           'phone' => 'required|string',
           'email' => 'nullable|string',
           'address' => 'nullable|string',
           'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
           'id_card_front' => 'nullable|required_with:id_card_back|image|mimes:jpeg,png,jpg,gif,svg',
           'id_card_back' => 'nullable|required_with:id_card_front|image|mimes:jpeg,png,jpg,gif,svg',
       ]);

        $data = $request->except('image','id_card_image');

        if ($request->has('image')){
            $data['image'] = imageUpload($request->file('image'),'customers/profile');
        }

        if ($request->has('id_card_front')|| $request->has('id_card_back')){
            $id_card_front = imageUpload($request->file('id_card_front'),'customers/card');
            $id_card_back = imageUpload($request->file('id_card_back'),'customers/card');
            $data['id_card_image'] = ['front'=>$id_card_front??null,'back'=>$id_card_back??null];
        }

        Customer::create($data);

        return response()->json([
            'message'   => __('Customer saved successfully'),
            'redirect'  => route('authorcustomers.index')
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
        //
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
            'business_id' => 'required|integer',
            'name' => 'required|string',
            'nick_name' => 'nullable|string',
            'phone' => 'required|string',
            'email' => 'nullable|string',
            'address' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'id_card_front' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'id_card_back' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',

        ]);

        $customer = Customer::findOrFail($id);
        $data = $request->except('image','id_card_image');

        if ($request->has('image')){
            $data['image'] = imageUpload($request->file('image'),'customers/profile', $request->image);
        }

        if ($request->has('id_card_front')|| $request->has('id_card_back')) {
            //check exists id card front side
            $customer->id_card_image ? $front_idcard = ltrim($customer->id_card_image[0], 'storage/') : $front_idcard = null;

            if ($request->has('id_card_front')) {

                $id_card_front = imageUpload($request->file('id_card_front'), 'customers/card', $front_idcard);
            } else {
                $id_card_front = $front_idcard;
            }
            //check exists id card back side
            $customer->id_card_image ? $back_idcard = ltrim($customer->id_card_image[1], 'storage/') : $back_idcard = null;

            if ($request->has('id_card_back')) {

                $id_card_back = imageUpload($request->file('id_card_back'), 'customers/card', $back_idcard);
            } else {
                $id_card_back = $back_idcard;
            }
            $data['id_card_image'] = ['front' => $id_card_front ?? null, 'back' => $id_card_back ?? null];
        }

            $customer->update($data);

        return response()->json([
            'message'   => __('Customer updated successfully'),
            'redirect'  => route('authorcustomers.index')
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
        $customer = Customer::findOrFail($id);
        uploadImageDelete(ltrim($customer->image,'storage/'));
        if ( $customer->id_card_image != null){
            uploadImageDelete(ltrim($customer->id_card_image[0],'storage/'));
            uploadImageDelete(ltrim($customer->id_card_image[1],'storage/'));
        }

        $customer->delete();

        return response()->json([
            'message'   => __('Customer deleted successfully'),
            'redirect'  => route('authorcustomers.index')
        ]);
    }

    public function status(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);
        $customer->update(['status' => $request->status]);
        return response()->json(['message' => 'Customer']);
    }

}
