<?php

namespace App\Http\Controllers;

use App\Models\BannerInfo;

use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return BannerInfo::all();
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
            'banner_image' => 'required',
            'title' => 'required',
            'description' =>'required'
        ]);
        return response([
            'success' => true,
            'message' => 'Data Created',
            'data' => BannerInfo::create($request->all())
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
            'message' => 'Here is your data',
            'data' => BannerInfo::find($id)
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
        $threed = BannerInfo::find($id);
        $threed->update($request->all());
        return response([
            'success' => true,
            'message' => 'Data Created',
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
            'message' => 'Data Created',
            'data' => BannerInfo::destroy($id)
        ],204); 
    }

    public function search($name)
    {
        return response([
            'success' => true,
            'message' => 'Data Created',
            'data' => BannerInfo::where('date', 'like', '%'.$name.'%')->get()
        ],200); 
    }
}
