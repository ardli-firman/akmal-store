<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sales;


class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request('cari') != null){
            $sales = Sales::where('nama',request('cari'))->first();
            return response()->json($sales);
        }

        return response()->json(Sales::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valid = $this->validate($request, [
            'nama' => 'required',
            'umur' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required'
        ]);

        $result = Sales::firstOrCreate($valid);

        return response()->json($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($salesId)
    {
        $sales = Sales::find($salesId);

        return response()->json($sales);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $salesId)
    {
        $sales = Sales::find($salesId);

        if($sales != null){
            $valid = $this->validate($request, [
                'nama' => 'required',
                'umur' => 'required',
                'alamat' => 'required',
                'no_hp' => 'required'
            ]);

            $sales->nama = $valid['nama'];
            $sales->umur = $valid['umur'];
            $sales->alamat = $valid['alamat'];
            $sales->no_hp = $valid['no_hp'];

            return response()->json($sales->save());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($salesId)
    {
        $sales = Sales::find($salesId);

        if($sales != null){
            return response()->json($sales->delete());
        }

    }
}
