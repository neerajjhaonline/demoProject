<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\Region;
use Session;


class RegionController extends Controller
{
    public function index()
    {
    	return view('masters.region.regionView');
    }

    public function create()
    {
    	return view('masters.region.regionCreate');
    }

    public function edit($id)
    {
    	$recId = region::findOrFail($id);
    	//dd($recId);
    	return view('masters.region.regionEdit',compact('recId'));
    }

    public function store(Request $req)
    {
    	$region = new Region();
    	$res = $region->validateRegion($req->all());

    	if ($res->fails()) {
            return redirect()->route('region.create')
                        ->withErrors($res)
                        ->withInput();
        }
        else{

        	$saveYN = $region->saveRegion($req->all());
        	if($saveYN){
        		Session::flash('message','Record Saved Successfully');
        		return redirect()->route('region.create');
        	}
        	else{

        		Session::flash('error','Record not Saved Successfully');
        		return redirect()->route('region.create');
        	}
        	
        }
    	
    }

    public function update(Request $req, $id)
    {
    	
    	$region = new Region();
    	$res = $region->validateRegion($req->all());

    	if ($res->fails()) {
            return redirect()->route('region.edit',$id)
                        ->withErrors($res)
                        ->withInput();
        }
        else{

        	$saveYN = $region->updateRegion($req->all(), $id);
        	if($saveYN){

        		Session::flash('message','Record Update Successfully');
        		return redirect()->route('region.edit',$id);
        	}
        	else{

        		Session::flash('error','Record not Updated Successfully');
        		return redirect()->route('region.edit',$id);	
        	}
        	
        }
    }

    public function destroy($id)
    {
    	$recId = Region::findOrFail($id);

    	$recId->delete();
    	    	
    	if($recId){
    		Session::flash('message','Record deleted Successfully');
    		return redirect()->route('region.index');
    	}
    	else{
    		Session::flash('error','Record not deletd Successfully');
    		return redirect()->route('region.index');	
    	}
    }
}
