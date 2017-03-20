<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\Mode;
use Session;


class ModeController extends Controller
{
    public function index()
    {
    	return view('masters.mode.modeView');
    }

    public function create()
    {
    	return view('masters.mode.modeCreate');
    }

    public function edit($id)
    {
    	$recId = mode::findOrFail($id);
    	//dd($recId);
    	return view('masters.mode.modeEdit',compact('recId'));
    }

    public function store(Request $req)
    {
    	$mode = new Mode();
    	$res = $mode->validateMode($req->all());

    	if ($res->fails()) {
            return redirect()->route('mode.create')
                        ->withErrors($res)
                        ->withInput();
        }
        else{

        	$saveYN = $mode->saveMode($req->all());
        	if($saveYN){
        		Session::flash('message','Record Saved Successfully');
        		return redirect()->route('mode.create');
        	}
        	else{

        		Session::flash('error','Record not Saved Successfully');
        		return redirect()->route('mode.create');
        	}
        	
        }
    	
    }

    public function update(Request $req, $id)
    {
    	
    	$mode = new Mode();
    	$res = $mode->validateMode($req->all());

    	if ($res->fails()) {
            return redirect()->route('mode.edit',$id)
                        ->withErrors($res)
                        ->withInput();
        }
        else{

        	$saveYN = $mode->updateMode($req->all(), $id);
        	if($saveYN){

        		Session::flash('message','Record Update Successfully');
        		return redirect()->route('mode.edit',$id);
        	}
        	else{

        		Session::flash('error','Record not Updated Successfully');
        		return redirect()->route('mode.edit',$id);	
        	}
        	
        }
    }

    public function destroy($id)
    {
    	$recId = Mode::findOrFail($id);

    	$recId->delete();
    	    	
    	if($recId){
    		Session::flash('message','Record deleted Successfully');
    		return redirect()->route('mode.index');
    	}
    	else{
    		Session::flash('error','Record not deletd Successfully');
    		return redirect()->route('mode.index');	
    	}
    }
}

