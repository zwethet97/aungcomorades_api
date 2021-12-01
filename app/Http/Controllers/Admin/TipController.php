<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tips;
use App\Models\todayTips;
use App\Models\TipRecord;
use Illuminate\Http\Request;

class TipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $tips = Tips::all();

        return view('admin.tips.index',[
            'tips' => $tips
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createTipProfile(Request $request)
    {   
        
        $imageName = time().'.'.$request->profile->extension(); 
        $bannerName = time().'.'.$request->banner->extension(); 
     
        $request->profile->move(public_path('tips/profileImages'), $imageName);
        $request->banner->move(public_path('tips'), $bannerName);

        Tips::insert([
            'name' => $request->name,
            'title' => $request->title,
            'profileImage' => $imageName,
            'description' => $request->description,
            'banner_image' => $bannerName
        ]);
        return back()->with('message','Tip Profile Added!');
    }

    public function showToday($id)
    {
        $data = todayTips::where('tip_id',$id)->get();

        return view('admin.tips.daily',[
            'tips' => $data,
            'tipuser_id' => $id
        ]);
    }

    public function createRecordTip(Request $request)
    {
        $bannerOneName = time().'record1.'.$request->bannerOne->extension();
        $bannerTwoName = time().'record2.'.$request->bannerTwo->extension();
        $bannerThreeName = time().'record3.'.$request->bannerThree->extension();
        $request->bannerOne->move(public_path('tipBanner'), $bannerOneName);
        $request->bannerTwo->move(public_path('tipBanner'), $bannerTwoName);
        $request->bannerThree->move(public_path('tipBanner'), $bannerThreeName);

        TipRecord::insert([
            'tip_id' => $request->tipuser_id,
            'banner_one' => $bannerOneName,
            'banner_two' => $bannerTwoName,
            'banner_three' => $bannerThreeName,
            'description_one' => $request->descriptionOne,
            'description_two' => $request->descriptionTwo,
            'description_three' => $request->descriptionThree,
            'date' => $request->date,
            'time' => $request->time,
            'result' => $request->result,
            'twod' => $request->tipnumber
        ]);

        return back()->with('message','Schedule Tip Added!');
    }

    public function createTodayTip(Request $request)
    {
        $bannerOneName = time().'t1.'.$request->bannerOne->extension();
        $bannerTwoName = time().'t2.'.$request->bannerTwo->extension();
        $bannerThreeName = time().'t3.'.$request->bannerThree->extension();
        $request->bannerOne->move(public_path('tips'), $bannerOneName);
        $request->bannerTwo->move(public_path('tips'), $bannerTwoName);
        $request->bannerThree->move(public_path('tips'), $bannerThreeName);

        todayTips::insert([
            'tip_id' => $request->tipuser_id,
            'date' => $request->date,
            'bannerImageOne' => $bannerOneName,
            'bannerImageTwo' => $bannerTwoName,
            'bannerImageThree' => $bannerThreeName,
            'imageOneDescription' => $request->descriptionOne,
            'imageTwoDescription' => $request->descriptionTwo,
            'imageThreeDescription' => $request->descriptionThree
        ]);

        return back()->with('message','Tip Record Added!');
    }

    public function showRecord($id)
    {
        $data = TipRecord::where('tip_id',$id)->get();

        return view('admin.tips.record',[
            'tips' => $data,
            'tipuser_id' => $id
        ]);
        
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
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
