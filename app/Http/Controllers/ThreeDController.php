<?php

namespace App\Http\Controllers;

use App\Models\DthreeD;

use Illuminate\Http\Request;

class ThreeDController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DthreeD::all();
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
            '3D' => 'required',
            'modern' => 'required',
            'internet' => 'required',
            'set' => 'required',
            'value' => 'required',
            'time' => 'required',
            'date' =>'required',
            'day' =>'required'

        ]);
        return DthreeD::create($request->all()); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return DthreeD::find($id);
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
        $threed = DthreeD::find($id);
        $threed->update($request->all());
        return $threed;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return DthreeD::destroy($id);
    }
}
