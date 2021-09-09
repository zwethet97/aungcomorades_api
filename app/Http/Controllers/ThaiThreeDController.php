<?php

namespace App\Http\Controllers;

use App\Models\ThaiThreeD;

use Illuminate\Http\Request;

class ThaiThreeDController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response([
            'success' => true,
            'message' => 'Data Found',
            'data' => ThaiThreeD::all()
        ],200);
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
            'Thai3D' => 'required',
            'time' => 'required',
            'date' =>'required',
            'day' =>'required'

        ]);
        return response([
            'success' => true,
            'message' => 'Data Created',
            'data' => ThaiThreeD::create($request->all())
        ],201); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response([
            'success' => true,
            'message' => 'Data Found',
            'data' => ThaiThreeD::find($id)
        ],200); 
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
        $threed = ThaiThreeD::find($id);
        $threed->update($request->all());
        return response([
            'success' => true,
            'message' => 'Data Updated',
            'data' => $threed
        ],200); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response([
            'success' => true,
            'message' => 'Data Deleted Successfully',
            'data' => ThaiThreeD::destroy($id)
        ],203); 
    }

    public function search($name)
    {
        return response([
            'success' => true,
            'message' => 'Data Deleted Successfully',
            'data' => ThaiThreeD::where('date', 'like', '%'.$name.'%')->get()
        ],203); 
        
    }
}
