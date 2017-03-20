<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\ProcessQueue;
use App\Model\Indexing;
use App\Model\Auditing;
use Session;


class RfiController extends Controller
{
    public function index()
    {
    	//$accessType = strtoupper(Session::get('userAccess'));

    	//if($accessType === 'ADMIN' || $accessType === 'SUPERADMIN' ){
    		$auditings = Auditing::rightJoin('process_queue','auditing.publishing_id', '=', 'process_queue.id')
                                ->Join('indexing', 'indexing.id', '=', 'process_queue.indexing_id')
                                ->leftJoin('mst_modes','mst_modes.id', '=', 'process_queue.mode_id')
                                ->leftJoin('mst_rfiType','mst_rfiType.id', '=', 'process_queue.rfiType_id')
                                ->leftJoin('mst_status','mst_status.id', '=', 'process_queue.status_id')
                                ->leftJoin('mst_status as auditStat','auditStat.id', '=', 'auditing.status_id')
                                ->leftJoin('mst_error_cat','mst_error_cat.id', '=', 'process_queue.error_cat_id')
                                ->leftJoin('mst_error_type','mst_error_type.id', '=', 'process_queue.error_type_id')
                                ->leftJoin('mst_user_access','mst_user_access.id', '=', 'process_queue.query_raised_by')
                                ->leftJoin('mst_user_access as errID','errID.id', '=', 'process_queue.error_done_by')
                                ->leftJoin('mst_user_access as auditorId','auditorId.id', '=', 'auditing.audit_by')
                                ->leftJoin('mst_request_type','mst_request_type.id', '=', 'indexing.req_type_id')
                                ->leftJoin('mst_region','mst_region.id', '=', 'indexing.region_id')
                                ->leftJoin('mst_container_type','mst_container_type.id', '=', 'indexing.cont_type_id')
                                ->leftJoin('mst_priority_type','mst_priority_type.id', '=', 'indexing.priority_id')
                                ->leftJoin('mst_user_access as publishID','publishID.id', '=', 'process_queue.publish_by')
                                ->select('indexing.request_no','indexing.mail_received_dt','mst_region.name as region','mst_container_type.name as container','mst_priority_type.name as priority','auditing.id as auditingId', 'mst_rfiType.rfiType_name as rfiName','mst_error_cat.name as errCatName', 'mst_error_type.name as errTypeName', 'mst_user_access.name as queryBy','indexing.cust_name','errID.name as errorBy','publishID.name as publishBy','mst_status.status_name as publishStatus','auditStat.status_name as auditStatus','process_queue.id as processQueueID','mst_request_type.name as request','auditorId.name as auditorName','auditing.audit_start_dt','auditing.audit_end_dt','auditing.tat as auditTat','process_queue.tat as publishingTat','auditing.oot as auditingOot','process_queue.oot as publishingOot','auditing.oot_remark as auditingRemark','process_queue.oot_remark as publishingRemark','auditing.comment as auditingComment','process_queue.comment as publishingComment')
                                ->where("mst_status.status_name",'PENDING IN')
                                ->orWhere("auditStat.status_name",'PENDING IN')
                                ->get();
                        
                             //dd($auditings);
    				//dd($publishings);

		
    						//dd($publishings->toSql());

			


    			     	//dd($publishings);
    	return view('rfiQueue.rfiView',compact('auditings'));
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


