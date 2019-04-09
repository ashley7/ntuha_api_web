<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Price;

class PriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Price::all()->last();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $prices = Price::all();
        return view('pages.price')->with(['prices'=>$prices]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $save_price = new Price($request->all());
        try {
            $save_price->save();
            return "Saved successfully";
        } catch (\Exception $e) {}
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
        $read_price = Price($id);
        return view('pages.edit_price')->with(['read_price'=>$read_price]);
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

        $save_price = Price($id);

        if (isset($request->price)) {
           $save_price->price = $request->price;
        }

        if (isset($request->type)) {
           $save_price->type = $request->type;
        }

        if (isset($request->rate)) {
           $save_price->rate = $request->rate;
        }

        if (isset($request->ratetype)) {
           $save_price->ratetype = $request->ratetype;
        }

        $save_price->save();

        return redirect()->route('price.create');
        
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
