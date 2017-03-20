<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\RfiType;
use Session;


class RfiTypeController extends Controller
{
    public function index()
    {
    	return view('masters.rfiType.rfiTypeView');
    }

    public function create()
    {
    	return view('masters.rfiType.rfiTypeCreate');
    }

    public function edit($id)
    {
    	$recId = rfiType::findOrFail($id);
    	//dd($recId);
    	return view('masters.rfiType.rfiTypeEdit',compact('recId'));
    }

    public function store(Request $req)
    {
    	$rfiType = new RfiType();
    	$res = $rfiType->validateRfiType($req->all());

    	if ($res->fails()) {
            return redirect()->route('rfiType.create')
                        ->withErrors($res)
                        ->withInput();
        }
        else{

        	$saveYN = $rfiType->saveRfiType($req->all());
        	if($saveYN){
        		Session::flash('message','Record Saved Successfully');
        		return redirect()->route('rfiType.create');
        	}
        	else{

        		Session::flash('error','Record not Saved Successfully');
        		return redirect()->route('rfiType.create');
        	}
        	
        }
    	
    }

    public function update(Request $req, $id)
    {
    	
    	$rfiType = new RfiType();
    	$res = $rfiType->validateRfiType($req->all());

    	if ($res->fails()) {
            return redirect()->route('rfiType.edit',$id)
                        ->withErrors($res)
                        ->withInput();
        }
        else{

        	$saveYN = $rfiType->updateRfiType($req->all(), $id);
        	if($saveYN){

        		Session::flash('message','Record Update Successfully');
        		return redirect()->route('rfiType.edit',$id);
        	}
        	else{

        		Session::flash('error','Record not Updated Successfully');
        		return redirect()->route('rfiType.edit',$id);	
        	}
        	
        }
    }

    public function destroy($id)
    {
    	$recId = RfiType::findOrFail($id);

    	$recId->delete();
    	    	
    	if($recId){
    		Session::flash('message','Record deleted Successfully');
    		return redirect()->route('rfiType.index');
    	}
    	else{
    		Session::flash('error','Record not deletd Successfully');
    		return redirect()->route('rfiType.index');	
    	}
    }
}
