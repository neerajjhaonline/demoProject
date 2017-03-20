<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\StatusCat;
use Session;


class StatusCatController extends Controller
{
    public function index()
    {
    	//$statusCat = StatusCat::pa();

    	return view('masters.statusCat.statusCatView');
    }

    public function create()
    {
    	return view('masters.statusCat.statusCatCreate');
    }

    public function edit($id)
    {
    	$recId = StatusCat::findOrFail($id);
    	//dd($recId);
    	return view('masters.statusCat.statusCatEdit',compact('recId'));
    }

    public function store(Request $req)
    {
    	$statusCat = new StatusCat();
    	$res = $statusCat->validateStatusCat($req->all());

    	if ($res->fails()) {
            return redirect('statusCat/create')
                        ->withErrors($res)
                        ->withInput();
        }
        else{

        	$saveYN = $statusCat->saveStatusCat($req->all());
        	if($saveYN){
        		Session::flash('message','Record Saved Successfully');
        		return redirect('statusCat/create');
        	}
        	else{

        		Session::flash('error','Record not Saved Successfully');
        		return redirect('statusCat/create');	
        	}
        	
        }
    	
    }

    public function update(Request $req, $id)
    {
    	
    	$statusCat = new StatusCat();
    	$res = $statusCat->validateStatusCat($req->all());

    	if ($res->fails()) {
            return redirect()->route('statusCat.edit',$id)
                        ->withErrors($res)
                        ->withInput();
        }
        else{

        	$saveYN = $statusCat->updateStatusCat($req->all(), $id);
        	if($saveYN){
        		Session::flash('message','Record Update Successfully');
        		return redirect()->route('statusCat.edit',$id);
        	}
        	else{

        		Session::flash('error','Record not Updated Successfully');
        		return redirect()->route('statusCat.edit',$id);	
        	}
        	
        }
    }

    public function destroy($id)
    {
    	$recId = StatusCat::findOrFail($id);

    	$recId->delete();
    	    	
    	if($recId){
        		Session::flash('message','Record deleted Successfully');
        		return redirect()->route('statusCat.index');
    	}
    	else{

    		Session::flash('error','Record not deletd Successfully');
    		return redirect()->route('statusCat.index');	
    	}
    }
}

