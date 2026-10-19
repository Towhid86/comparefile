<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\PaymentType;
use Illuminate\Http\Request;

class BaariPaymentTypeController extends Controller
{
    public function __construct(){

    }


    public function index()
    {
        $payment_types = PaymentType::latest()->paginate(10);
        return view('author.payment-types.index',compact('payment_types'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:payment_types,id',
            'status' => 'nullable|in:on',
        ]);


        PaymentType::create($request->except('status') + [
                'status' => $request->status ? 1 : 0,
            ]);

        return response()->json([
            'message' => __('Payment Type created successfully'),
            'redirect' => route('author.payment-types.index'),
        ]);

    }

    public function update(Request $request, PaymentType $paymentType)
    {
        $request->validate([
            'name' => 'required|string|unique:payment_types,id,'.$paymentType->id,
            'status' => 'nullable|in:on',
        ]);

        $paymentType->update($request->except('status') + [
                'status' => $request->status ? 1 : 0,
            ]);

        return response()->json([
            'message' => __('Payment Type updated successfully'),
            'redirect' => route('author.payment-types.index'),
        ]);
    }

    public function destroy(PaymentType $paymentType)
    {
        //
    }
}
