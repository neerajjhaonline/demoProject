<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\ProcessQueue;
use App\Model\Indexing;
use Session;


class PublishingController extends Controller
{
    public function index()
    {
    	//$accessType = strtoupper(Session::get('userAccess'));

    	//if($accessType === 'ADMIN' || $accessType === 'SUPERADMIN' ){
    		$publishings  = Indexing::leftJoin('process_queue', 'indexing.id', '=', 'process_queue.indexing_id')
    						->leftJoin('mst_modes','mst_modes.id', '=', 'process_queue.mode_id')
    						->leftJoin('mst_rfiType','mst_rfiType.id', '=', 'process_queue.rfiType_id')
    						->leftJoin('mst_status','mst_status.id', '=', 'process_queue.status_id')
    						->leftJoin('mst_error_cat','mst_error_cat.id', '=', 'process_queue.error_cat_id')
    						->leftJoin('mst_error_type','mst_error_type.id', '=', 'process_queue.error_type_id')
    						->leftJoin('mst_user_access','mst_user_access.id', '=', 'process_queue.query_raised_by')
    						->leftJoin('mst_user_access as errID','errID.id', '=', 'process_queue.error_done_by')
    						->leftJoin('mst_user_access as publishID','publishID.id', '=', 'process_queue.publish_by')
    						->select('process_queue.*','indexing.*','indexing.id as indexingId', 'mst_rfiType.rfiType_name as rfiName','mst_error_cat.name as errCatName', 'mst_error_type.name as errTypeName', 'mst_user_access.name as queryBy', 'errID.name as errorBy','publishID.name as publishBy','mst_status.status_name', 'process_queue.id as processQueueID')
							->get();
    				

		//	$userId = Session::get('userId');

    	//}
    						//dd($publishings->toSql());

			


    			     	//dd($publishings);
    	return view('publishing.publishingView',compact('publishings'));
    }

    public function show($id)
    {
    	//dd($id);
    	$indexing = Indexing::find($id);
    	return view('publishing.publishingCreate',compact('indexing'));
    }

    public function create()
    {
    	//dd($id);
    	
    	return view('publishing.publishingCreate');
    }

    public function edit($id)
    {
    	$recId = ProcessQueue::find($id);
    	//dd($str = json_decode($recId->mode_id));
    	$indexing = Indexing::find($recId->indexing_id);
    	
    	//dd($recId);
    	return view('publishing.publishingEdit',compact('recId','indexing'));
    }

    public function store(Request $req)
    {
    	$publishing = new ProcessQueue();
    	$res = $publishing->validateProcessQueue($req->all());

    	if ($res->fails()) {
    		//dd($req->indexing_id);
            return redirect()->route('publishing.show', $req->indexing_id)
                        ->withErrors($res)
                        ->withInput();
        }
        else{

        	//$result = ProcessQueue::where('indexing_id',$data['indexing_id'])->->exists();
            $saveYN = $publishing->saveProcessQueue($req->all());

        	if($saveYN){
        		Session::flash('message','Record Saved Successfully');
        		return redirect()->route('publishing.index');
        	}
        	else{

        		Session::flash('error','Record not Saved Successfully');
        		return redirect()->route('publishing.show', $req->indexing_id);
        	}
        	
        }
    	
    }

    public function update(Request $req, $id)
    {
    	
    	$publishing = new ProcessQueue();
    	$res = $publishing->validateProcessQueue($req->all());

    	if ($res->fails()) {
            return redirect()->route('publishing.edit',$id)
                        ->withErrors($res)
                        ->withInput();
        }
        else{

        	$saveYN = $publishing->updateProcessQueue($req->all(), $id);
        	if($saveYN){

        		Session::flash('message','Record Update Successfully');
        		return redirect()->route('publishing.edit',$id);
        	}
        	else{

        		Session::flash('error','Record not Updated Successfully');
        		return redirect()->route('publishing.edit',$id);	
        	}
        	
        }
    }

    public function destroy($id)
    {
    	$recId = ProcessQueue::findOrFail($id);

    	$recId->delete();
    	    	
    	if($recId){
    		Session::flash('message','Record deleted Successfully');
    		return redirect()->route('publishing.index');
    	}
    	else{
    		Session::flash('error','Record not deletd Successfully');
    		return redirect()->route('publishing.index');	
    	}
    }
}


