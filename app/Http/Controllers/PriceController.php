<?php


namespace App\Http\Controllers;


use App\Price;
use App\Subscription;
use Auth;
use Session;
use Illuminate\Http\Request;


class PriceController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        //$this->middleware('permission:price-list|price-edit', ['only' => ['index','show']]);
        //$this->middleware('permission:price-edit', ['only' => ['edit','update']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // class A
        $class_a_price = Price::where(['id' => 1, 'class_type' => 1])->first();
        $class_a_priceHistorys = Price::where('id', '!=', 1)->where('class_type', 1)->orderBy('id', 'desc')->paginate(10);

        // class B
        $class_b_price = Price::where(['active' => 1, 'class_type' => 2])->first();
        $class_b_priceHistorys = Price::where('active', '!=', 1)->where('class_type', 2)->orderBy('id', 'desc')->paginate(10);

        return view('admin.prices.index',compact('class_a_price', 'class_a_priceHistorys', 'class_b_price', 'class_b_priceHistorys'));
    }

    public function create(Request $request)
    {
        $classType = $request->get('classType');
        return view('admin.prices.create', compact('classType'));
    }

    public function show($id)
    {
        //
    }

    // public function edit(Request $request, Price $price)
    // {
    //     $classType = $request->get('classType');

    //     return $classType;
    //     return view('admin.prices.edit',compact('price', 'classType'));
    // }

    public function store(Request $request)
    {
        request()->validate([
            'latest_price' => 'required',
            'dealing_date' => 'required',
            'ytd_return' => 'required',
            'quarterly_return' => 'required',
        ]);

        if ($request->has('class_type')) {

            $requestData = $request->all();
            $created = Price::create($requestData);

            $classType = $request->class_type;
            
            if ($created) {
                // $priceData = Price::find(1);
                $priceData = Price::where(['class_type' => $classType, 'active' => 1])->first();
                $requestData = $request->all();
                $requestData['active'] = 1;
                $priceData->update($requestData);
            }

            return redirect()->route('prices.index')
                        ->with('success','price added successfully');

        } else {

            return redirect()->route('prices.index')
                        ->with('error','There is no class have you selected!');
        }
    }

    public function editPrice(Request $request)
    {
        $PriceId = $request->get('PriceId');
        $classType = $request->get('classType');

        $price = Price::findOrFail($PriceId);
        
        return view('admin.prices.edit',compact('price', 'classType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Price $price)
    {
        request()->validate([
            'latest_price' => 'required',
            'dealing_date' => 'required',
            'ytd_return' => 'required',
            'quarterly_return' => 'required',
        ]);

        // return $request->all();

        // return $price;

        // $priceData = Price::find($price->id);

        $classType = $request->class_type;
        $priceData = Price::where(['id' => $price->id, 'class_type' => $classType])->first();

        $price->update($request->all());




        // if ($price->id == 1) {
            
        //     // if($request->get('latest_price') != $priceData->latest_price){
        //     if($request->get('latest_price')){

        //         $requestData = $request->all();
        //         Price::create($requestData);

        //         $price = Price::where('class_type', $classType)->where('active',1)->first();


        //         $subscriptions = Subscription::where('is_first', 1)->get();

        //         foreach ($subscriptions as $key => $subscription) {
                    
        //             $latest_price = $price->latest_price;
        //             $current_share = $subscription->no_of_share;
        //             // $current_value = $subscription->current_value;

        //             $current_amount = $latest_price*$current_share;

        //             $data['latest_price'] = $price->latest_price;
        //             $data['current_value'] = $current_amount;
                    
        //             Subscription::where('id', $subscription->id)->update($data);
        //         }
                
        //     }
        // }

        return redirect()->route('prices.index')
                        ->with('success','price updated successfully');
    }

}