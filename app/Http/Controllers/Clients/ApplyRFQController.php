<?php

namespace App\Http\Controllers\Clients;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rfq;


class ApplyRFQController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		/*
		 * CS
		 *
		 * 'client.rfq.apply-rfq' is represents the directory path to /resources/views/client/rfq/apply-rfq.blade.php
		 */
        // from --> resources/views/client/rfq/rfq-apply.blade.php
        return view('client.rfq.apply-rfq', [
            'intent' => auth()->user()->createSetupIntent(),
            'rfqsInfo' => Rfq::get("project_name")
        ]);
        // return view('client.rfq.apply-rfq');
        
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Go Stripe 
        auth()->user()->charge(40000, $request->paymentMethod);
        // Go DB
        Rfq::insert(
            [   
                'name' => "Julius Test 1",
                'telephone' => '92228762',
                'email' => 'juliusSS@starrystep.com',
                'company_name' => 'Starry Starry Night',
                'company_address' => 'Kwun Tong East',
                'project_name' => 1,
                'is_tvp' => 1,
                'project_requirements' => 'Req 1, Req 2, Req 3',
                'expected_budget' => '180000',
                'notes' => 'Note 1, Note 2, Note 3',
                'number_of_rfqs' => 2,
                'payment_received' => 800,
                'ip' => '127.0.0.8',
                'stripe_data' => 'NO DATA YET硬Dumn',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
        // auth()->user()->newSubscription('cashier', $request->plan)->create($request->paymentMethod);
        // auth()->user()->checkout('price_1L0j7eElWv4kz27VPrADuDut')
        // return redirect('client/rfq');
        // auth()->user()->createAsStripeCustomer();
        // auth()->user()->updateDefaultPaymentMethod($request->paymentMethod);
        // auth()->user()->updateDefaultPaymentMethod($request->paymentMethod);
        return redirect('client/rfq');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
