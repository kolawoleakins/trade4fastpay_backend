<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTradeRequest;
use App\Http\Resources\TradeResource;
use App\Models\Trade;
use App\Traits\HttpResponses;
use Illuminate\Console\View\Components\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TradeController extends Controller
{

    use HttpResponses;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return TradeResource::collection(
            Trade::where('user_id',Auth::user()->id)->get()
        );
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
    public function store(StoreTradeRequest $request)
    {
      $request->validated($request->all());

      $trade = Trade::create(
        [
            'user_id' => Auth::user()->id,
            'amount_btc' => $request->amount_btc,
            'amount_usd' =>$request->amount_usd,
            'settlement_country'=>$request->settlement_country, 
            'bank' => $request->bank,
            'account_number'=>$request->account_number,
            'beneficiary' => $request->beneficiary,
            'trade_status' => $request->trade_status
        ]
        );


        return new TradeResource($trade);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Trade $trade)
    {
        //

        if(Auth::user()->id !== $trade->user_id) 
        {
            return $this->failed('','You are not authorized to make this request',403);

        }
        return new TradeResource($trade);
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
    public function destroy(Trade $trade)
    {
        //
        if(Auth::user()->id !== $trade->user_id) 
        {
            return $this->failed('','You are not authorized to make this request',403);

        }
        $trade->delete();
        return response(null,204);
    }
}
