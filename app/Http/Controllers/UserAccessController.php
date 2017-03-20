<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\UserAccess;
use Session;


class UserAccessController extends Controller
{
    public function index()
    {
    	return view('masters.userAccess.userAccessView');
    }

    public function create()
    {
    	return view('masters.userAccess.userAccessCreate');
    }

    public function edit($id)
    {
    	$recId = UserAccess::findOrFail($id);
    	//dd($recId);
    	return view('masters.userAccess.userAccessEdit',compact('recId'));
    }

    public function store(Request $req)
    {
    	$userAccess = new UserAccess();
    	$res = $userAccess->validateUserAccess($req->all());

    	if ($res->fails()) {
            return redirect()->route('userAccess.create')
                        ->withErrors($res)
                        ->withInput();
        }
        else{

        	$saveYN = $userAccess->saveUserAccess($req->all());
        	if($saveYN){
        		Session::flash('message','Record Saved Successfully');
        		return redirect()->route('userAccess.create');
        	}
        	else{

        		Session::flash('error','Record not Saved Successfully');
        		return redirect()->route('userAccess.create');
        	}
        	
        }
    	
    }

    public function update(Request $req, $id)
    {
    	
    	$userAccess = new UserAccess();
    	$res = $userAccess->validateUserAccess($req->all(), $id);

    	if ($res->fails()) {
            return redirect()->route('userAccess.edit',$id)
                        ->withErrors($res)
                        ->withInput();
        }
        else{

        	$saveYN = $userAccess->updateUserAccess($req->all(), $id);
        	if($saveYN){

        		Session::flash('message','Record Update Successfully');
        		return redirect()->route('userAccess.edit',$id);
        	}
        	else{

        		Session::flash('error','Record not Updated Successfully');
        		return redirect()->route('userAccess.edit',$id);	
        	}
        	
        }
    }

    public function destroy($id)
    {
    	$recId = UserAccess::findOrFail($id);

    	$recId->delete();
    	    	
    	if($recId){
    		Session::flash('message','Record deleted Successfully');
    		return redirect()->route('userAccess.index');
    	}
    	else{
    		Session::flash('error','Record not deletd Successfully');
    		return redirect()->route('userAccess.index');	
    	}
    }
}

