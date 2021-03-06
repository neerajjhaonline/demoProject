<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\RequestType;
use Session;


class RequestTypeController extends Controller
{
    public function index()
    {
    	return view('masters.requestType.requestTypeView');
    }

    public function create()
    {
    	return view('masters.requestType.requestTypeCreate');
    }

    public function edit($id)
    {
    	$recId = requestType::findOrFail($id);
    	//dd($recId);
    	return view('masters.requestType.requestTypeEdit',compact('recId'));
    }

    public function store(Request $req)
    {
    	$requestType = new RequestType();
    	$res = $requestType->validateRequestType($req->all());

    	if ($res->fails()) {
            return redirect()->route('requestType.create')
                        ->withErrors($res)
                        ->withInput();
        }
        else{

        	$saveYN = $requestType->saveRequestType($req->all());
        	if($saveYN){
        		Session::flash('message','Record Saved Successfully');
        		return redirect()->route('requestType.create');
        	}
        	else{

        		Session::flash('error','Record not Saved Successfully');
        		return redirect()->route('requestType.create');
        	}
        	
        }
    	
    }

    public function update(Request $req, $id)
    {
    	
    	$requestType = new RequestType();
    	$res = $requestType->validateRequestType($req->all());

    	if ($res->fails()) {
            return redirect()->route('requestType.edit',$id)
                        ->withErrors($res)
                        ->withInput();
        }
        else{

        	$saveYN = $requestType->updateRequestType($req->all(), $id);
        	if($saveYN){

        		Session::flash('message','Record Update Successfully');
        		return redirect()->route('requestType.edit',$id);
        	}
        	else{

        		Session::flash('error','Record not Updated Successfully');
        		return redirect()->route('requestType.edit',$id);	
        	}
        	
        }
    }

    public function destroy($id)
    {
    	$recId = RequestType::findOrFail($id);

    	$recId->delete();
    	    	
    	if($recId){
    		Session::flash('message','Record deleted Successfully');
    		return redirect()->route('requestType.index');
    	}
    	else{
    		Session::flash('error','Record not deletd Successfully');
    		return redirect()->route('requestType.index');	
    	}
    }
}
