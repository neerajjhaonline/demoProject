<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\PriorityType;
use Session;


class PriorityTypeController extends Controller
{
    public function index()
    {
    	return view('masters.priorityType.priorityTypeView');
    }

    public function create()
    {
    	return view('masters.priorityType.priorityTypeCreate');
    }

    public function edit($id)
    {
    	$recId = priorityType::findOrFail($id);
    	//dd($recId);
    	return view('masters.priorityType.priorityTypeEdit',compact('recId'));
    }

    public function store(Request $req)
    {
    	$priorityType = new PriorityType();
    	$res = $priorityType->validatePriorityType($req->all());

    	if ($res->fails()) {
            return redirect()->route('priorityType.create')
                        ->withErrors($res)
                        ->withInput();
        }
        else{

        	$saveYN = $priorityType->savePriorityType($req->all());
        	if($saveYN){
        		Session::flash('message','Record Saved Successfully');
        		return redirect()->route('priorityType.create');
        	}
        	else{

        		Session::flash('error','Record not Saved Successfully');
        		return redirect()->route('priorityType.create');
        	}
        	
        }
    	
    }

    public function update(Request $req, $id)
    {
    	
    	$priorityType = new PriorityType();
    	$res = $priorityType->validatePriorityType($req->all());

    	if ($res->fails()) {
            return redirect()->route('priorityType.edit',$id)
                        ->withErrors($res)
                        ->withInput();
        }
        else{

        	$saveYN = $priorityType->updatePriorityType($req->all(), $id);
        	if($saveYN){

        		Session::flash('message','Record Update Successfully');
        		return redirect()->route('priorityType.edit',$id);
        	}
        	else{

        		Session::flash('error','Record not Updated Successfully');
        		return redirect()->route('priorityType.edit',$id);	
        	}
        	
        }
    }

    public function destroy($id)
    {
    	$recId = PriorityType::findOrFail($id);

    	$recId->delete();
    	    	
    	if($recId){
    		Session::flash('message','Record deleted Successfully');
    		return redirect()->route('priorityType.index');
    	}
    	else{
    		Session::flash('error','Record not deletd Successfully');
    		return redirect()->route('priorityType.index');	
    	}
    }
}

