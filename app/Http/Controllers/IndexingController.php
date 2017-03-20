<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\Indexing;
use App\Model\RequestNumber;
use Session, DateTime;


class IndexingController extends Controller
{
    public function index()
    {
    	$indexings = Indexing::orderBy('priority_id')->orderBy('mail_received_dt')->paginate(15);
    	//dd($indexings);
    	return view('indexing.indexingView',compact('indexings'));
    }

    public function create()
    {
    	return view('indexing.indexingCreate');
    }

    public function edit($id)
    {
    	$recId = Indexing::findOrFail($id);
    	// convert mail received date and time as mysql database  format before save
    	$recId->mail_received_dt = date('m/d/Y h:i:s A',strtotime($recId->mail_received_dt));
    	//dd($recId);
    	return view('indexing.indexingEdit',compact('recId'));
    }

    public function store(Request $req)
    {
    	
    	$indexing = new Indexing();
    	$res = $indexing->validateIndexing($req->all());

    	if ($res->fails()) {
            return redirect()->route('indexing.create')
                        ->withErrors($res)
                        ->withInput();
        }
        else{

        	$saveYN = $indexing->saveIndexing($req->all());
        	if($saveYN){
        		Session::flash('message','Record Saved Successfully');
        		return redirect()->route('indexing.create');
        	}
        	else{

        		Session::flash('error','Record not Saved Successfully');
        		return redirect()->route('indexing.create');
        	}
        	
        }
    	
    }

    public function update(Request $req, $id)
    {
    	
    	$indexing = new Indexing();
    	$res = $indexing->validateIndexing($req->all());

    	if ($res->fails()) {
            return redirect()->route('indexing.edit',$id)
                        ->withErrors($res)
                        ->withInput();
        }
        else{

        	$saveYN = $indexing->updateIndexing($req->all(), $id);
        	if($saveYN){

        		Session::flash('message','Record Update Successfully');
        		return redirect()->route('indexing.edit',$id);

        	}
        	else{

        		Session::flash('error','Record not Updated Successfully');
        		return redirect()->route('indexing.edit',$id);	
        	}
        	
        }
    }

    public function destroy($id)
    {
    	$recId = Indexing::findOrFail($id);

    	$recId->delete();
    	    	
    	if($recId){
    		Session::flash('message','Record deleted Successfully');
    		return redirect()->route('indexing.index');
    	}
    	else{
    		Session::flash('error','Record not deletd Successfully');
    		return redirect()->route('indexing.index');	
    	}
    }

/*requestNumber function for creating Request number after selection of mail date and time*/
    public function requestNumber(Request $req)
    {
    	if($req->date){
	    	$date  = explode(' ', $req->date);
	    	$date = new DateTime($date[0]); //date which selected
			$week = $date->format("W"); //week no
			$day = $date->format("d"); //day
			$month = $date->format("m"); //month
			$reqNum['reqNum'] = "WK$week/$day/$month#$req->id"; 
			echo json_encode($reqNum);

		}
    }
}

