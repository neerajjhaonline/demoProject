<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\Office;
use Session;


class OfficeController extends Controller
{
    public function index()
    {
    	//$office = Office::pa();

    	return view('masters.office.viewOffice');
    }

    public function create()
    {
    	return view('masters.office.officeCreate');
    }

    public function edit($id)
    {
    	$recId = Office::findOrFail($id);
    	//dd($recId);
    	return view('masters.office.officeEdit',compact('recId'));
    }

    public function store(Request $req)
    {
    	$office = new Office();
    	$res = $office->validateOffice($req->all());

    	if ($res->fails()) {
            return redirect('office/create')
                        ->withErrors($res)
                        ->withInput();
        }
        else{

        	$saveYN = $office->saveOffice($req->all());
        	if($saveYN){
        		Session::flash('message','Record Saved Successfully');
        		return redirect('office/create');
        	}
        	else{

        		Session::flash('error','Record not Saved Successfully');
        		return redirect('office/create');	
        	}
        	
        }
    	
    }

    public function update(Request $req, $id)
    {
    	
    	$office = new Office();
    	$res = $office->validateOffice($req->all());

    	if ($res->fails()) {
            return redirect()->route('office.edit',$id)
                        ->withErrors($res)
                        ->withInput();
        }
        else{

        	$saveYN = $office->updateOffice($req->all(), $id);
        	if($saveYN){
        		Session::flash('message','Record Update Successfully');
        		return redirect()->route('office.edit',$id);
        	}
        	else{

        		Session::flash('error','Record not Updated Successfully');
        		return redirect()->route('office.edit',$id);	
        	}
        	
        }
    }

    public function destroy($id)
    {
    	$recId = Office::findOrFail($id);

    	$recId->delete();
    	    	
    	if($recId){
        		Session::flash('message','Record deleted Successfully');
        		return redirect()->route('office.index');
    	}
    	else{

    		Session::flash('error','Record not deletd Successfully');
    		return redirect()->route('office.index');	
    	}
    }
}
