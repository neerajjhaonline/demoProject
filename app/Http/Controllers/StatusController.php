<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\Status;
use Session;

class StatusController extends Controller
{
    public function index()
    {
    	//$status = Status::pa();

    	return view('masters.status.statusView');
    }

    public function create()
    {
    	return view('masters.status.statusCreate');
    }

    public function edit($id)
    {
    	$recId = Status::findOrFail($id);
    	//dd($recId);
    	return view('masters.status.statusEdit',compact('recId'));
    }

    public function store(Request $req)
    {
    	$status = new Status();
    	$res = $status->validateStatus($req->all());

    	if ($res->fails()) {
            return redirect('status/create')
                        ->withErrors($res)
                        ->withInput();
        }
        else{

        	$saveYN = $status->saveStatus($req->all());
        	if($saveYN){
        		Session::flash('message','Record Saved Successfully');
        		return redirect('status/create');
        	}
        	else{

        		Session::flash('error','Record not Saved Successfully');
        		return redirect('status/create');	
        	}
        	
        }
    	
    }

    public function update(Request $req, $id)
    {
    	
    	$status = new Status();
    	$res = $status->validateStatus($req->all());

    	if ($res->fails()) {
            return redirect()->route('status.edit',$id)
                        ->withErrors($res)
                        ->withInput();
        }
        else{

        	$saveYN = $status->updateStatus($req->all(), $id);
        	if($saveYN){
        		Session::flash('message','Record Update Successfully');
        		return redirect()->route('status.edit',$id);
        	}
        	else{

        		Session::flash('error','Record not Updated Successfully');
        		return redirect()->route('status.edit',$id);	
        	}
        	
        }
    }

    public function destroy($id)
    {
    	$recId = Status::findOrFail($id);

    	$recId->delete();
    	    	
    	if($recId){
        		Session::flash('message','Record deleted Successfully');
        		return redirect()->route('status.index');
    	}
    	else{

    		Session::flash('error','Record not deletd Successfully');
    		return redirect()->route('status.index');	
    	}
    }
}

