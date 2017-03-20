<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\Commodity;
use Session;

class CommodityController extends Controller
{
    public function index()
    {
    	//$commodity = Commodity::pa();

    	return view('masters.commodity.commodityView');
    }

    public function create()
    {
    	return view('masters.commodity.commodityCreate');
    }

    public function edit($id)
    {
    	$recId = Commodity::findOrFail($id);
    	//dd($recId);
    	return view('masters.commodity.commodityEdit',compact('recId'));
    }

    public function store(Request $req)
    {
    	$commodity = new Commodity();
    	$res = $commodity->validateCommodity($req->all());

    	if ($res->fails()) {
            return redirect('commodity/create')
                        ->withErrors($res)
                        ->withInput();
        }
        else{

        	$saveYN = $commodity->saveCommodity($req->all());
        	if($saveYN){
        		Session::flash('message','Record Saved Successfully');
        		return redirect('commodity/create');
        	}
        	else{

        		Session::flash('error','Record not Saved Successfully');
        		return redirect('commodity/create');	
        	}
        	
        }
    	
    }

    public function update(Request $req, $id)
    {
    	
    	$commodity = new Commodity();
    	$res = $commodity->validateCommodity($req->all());

    	if ($res->fails()) {
            return redirect()->route('commodity.edit',$id)
                        ->withErrors($res)
                        ->withInput();
        }
        else{

        	$saveYN = $commodity->updateCommodity($req->all(), $id);
        	if($saveYN){
        		Session::flash('message','Record Update Successfully');
        		return redirect()->route('commodity.edit',$id);
        	}
        	else{

        		Session::flash('error','Record not Updated Successfully');
        		return redirect()->route('commodity.edit',$id);	
        	}
        	
        }
    }

    public function destroy($id)
    {
    	$recId = Commodity::findOrFail($id);

    	$recId->delete();
    	    	
    	if($recId){
        		Session::flash('message','Record deleted Successfully');
        		return redirect()->route('commodity.index');
    	}
    	else{

    		Session::flash('error','Record not deletd Successfully');
    		return redirect()->route('commodity.index');	
    	}
    }
}

