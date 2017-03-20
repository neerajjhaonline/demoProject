<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\Tat;
use Session;


class TatController extends Controller
{
    public function index()
    {
    	return view('masters.tat.tatView');
    }

    public function create()
    {
    	return view('masters.tat.tatCreate');
    }

    public function edit($id)
    {
    	$recId = tat::findOrFail($id);
    	//dd($recId);
    	return view('masters.tat.tatEdit',compact('recId'));
    }

    public function store(Request $req)
    {
    	$tat = new Tat();
    	$res = $tat->validateTat($req->all());

    	if ($res->fails()) {
            return redirect()->route('tat.create')
                        ->withErrors($res)
                        ->withInput();
        }
        else{

        	$saveYN = $tat->saveTat($req->all());
        	if($saveYN){
        		Session::flash('message','Record Saved Successfully');
        		return redirect()->route('tat.create');
        	}
        	else{

        		Session::flash('error','Record not Saved Successfully');
        		return redirect()->route('tat.create');
        	}
        	
        }
    	
    }

    public function update(Request $req, $id)
    {
    	
    	$tat = new Tat();
    	$res = $tat->validateTat($req->all());

    	if ($res->fails()) {
            return redirect()->route('tat.edit',$id)
                        ->withErrors($res)
                        ->withInput();
        }
        else{

        	$saveYN = $tat->updateTat($req->all(), $id);
        	if($saveYN){

        		Session::flash('message','Record Update Successfully');
        		return redirect()->route('tat.edit',$id);
        	}
        	else{

        		Session::flash('error','Record not Updated Successfully');
        		return redirect()->route('tat.edit',$id);	
        	}
        	
        }
    }

    public function destroy($id)
    {
    	$recId = Tat::findOrFail($id);

    	$recId->delete();
    	    	
    	if($recId){
    		Session::flash('message','Record deleted Successfully');
    		return redirect()->route('tat.index');
    	}
    	else{
    		Session::flash('error','Record not deletd Successfully');
    		return redirect()->route('tat.index');	
    	}
    }
}


