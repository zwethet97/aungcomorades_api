<?php

namespace App\Http\Controllers;
use App\Models\DtwoD;

use Illuminate\Http\Request;

class TwoDController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DtwoD::all();
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
            '2D' => 'required',
            'modern' => 'required',
            'internet' => 'required',
            'time' => 'required',
            'date' =>'required',
            'day' =>'required'

        ]);
        return DtwoD::create($request->all());  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       return DtwoD::find($id);
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
        $twod = DtwoD::find($id);
        $twod->update($request->all());
        return $twod;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return DtwoD::destroy($id);
    }
}
