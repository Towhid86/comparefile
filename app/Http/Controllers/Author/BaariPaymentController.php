<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;

class BaariPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments   = PaymentGateway::paginate(10);
        $currencies = Currency::where('status',1)->get();
        return view('author.payment.index',compact('payments','currencies'));
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
            'name'          => 'required|string|unique:payment_gateways|max:255',
            'client_id'     => 'required|string|max:255',
            'secret_key'    => 'nullable|string|max:255',
            'status'        => 'required|integer',
        ]);

        PaymentGateway::create($request->all());

        return response()->json([
            'message'   => __('Data saved successfully'),
            'redirect'  => route('authorpayments.index')
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $payment = PaymentGateway::findOrFail($id);
        return response()->json($payment);
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
            'name'        => 'required|string|max:255|unique:payment_gateways,name,'.$id,
            'client_id'   => 'required|string|max:255',
            'secret_key'  => 'nullable|string|max:255',
            'status'      => 'required|integer',
        ]);

        $payment = PaymentGateway::findOrFail($id);
        $payment->update($request->all());

        return response()->json([
            'message'   => __('Data updated successfully'),
            'redirect'  => route('authorpayments.index')
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
        $payment = PaymentGateway::findOrFail($id);
        $payment->delete();
        return response()->json([
            'message'   => __('Deleted successfully'),
            'redirect'  => route('authorpayments.index')
        ]);
    }

    public function status(Request $request, $id)
    {
        $payment = PaymentGateway::findOrFail($id);
        $payment->update(['status' => $request->status]);
        return response()->json(['message' => 'Payment']);
    }

    public function currencyUpdate(Request $request)
    {
        $request->validate([
            'currency_id' => 'required|integer',
        ]);

        $currency = Currency::findOrFail($request->currency_id);

        if ($currency->default == 0) {
            // default value of all currencies set to 0 except current request
            Currency::where('id', '!=', $currency->id)->update(['default' => 0]);
            $currency->update(['default' => 1]);
        } else {
            return response()->json( __('Select other currency , already it set as default'), 404);
        }
        return response()->json(__('Currency updated successfully.'));
    }
}
