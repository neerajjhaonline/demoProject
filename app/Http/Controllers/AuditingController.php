<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\Auditing;
use App\Model\Indexing;
use App\Model\ProcessQueue;
use Session;


class AuditingController extends Controller
{
    public function index()
    {
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
	    						->where("mst_status.status_name",'SEND TO AUDIT')
	    						->where("auditStat.status_name",'<>','DONE')
	    						->get();
						
    	//dd($auditings->toarray());

    	return view('auditing.auditingView',compact('auditings'));
    }

    public function show($id)
    {
    	//dd($id);
    	$recId = ProcessQueue::find($id);
    	$indexing = Indexing::find($recId->indexing_id);
    	return view('auditing.auditingCreate',compact('indexing','recId'));
    }

    public function create()
    {
    	//dd($id);
    	
    	return view('auditing.auditingCreate');
    }

    public function edit($id)
    {
    	$audId 		= Auditing::find($id);
    	$recId 		= ProcessQueue::find($audId->publishing_id);
    	//dd($str = json_decode($recId->mode_id));
    	$indexing 	= Indexing::find($recId->indexing_id);
    	
    	//dd($recId);
    	return view('auditing.auditingEdit',compact('recId','indexing','audId'));
    }

    public function store(Request $req)
    {
    	$auditing = new Auditing();
    	$res = $auditing->validateAuditing($req->all());

    	if ($res->fails()) {
    		//dd($req->indexing_id);
            return redirect()->route('auditing.show', $req->publishing_id)
                        ->withErrors($res)
                        ->withInput();
        }
        else{

        	//$result = Auditing::where('indexing_id',$data['indexing_id'])->->exists();

        	$saveYN = $auditing->saveAuditing($req->all());

        	if($saveYN){
        		Session::flash('message','Record Saved Successfully');
        		return redirect()->route('auditing.index');
        	}
        	else{

        		Session::flash('error','Record not Saved Successfully');
        		return redirect()->route('auditing.show', $req->indexing_id);
        	}
        	
        }
    	
    }

    public function update(Request $req, $id)
    {
    	
    	$auditing = new Auditing();
    	$res = $auditing->validateAuditing($req->all());

    	if ($res->fails()) {
            return redirect()->route('auditing.edit',$id)
                        ->withErrors($res)
                        ->withInput();
        }
        else{

        	$saveYN = $auditing->updateAuditing($req->all(), $id);
        	if($saveYN){

        		Session::flash('message','Record Update Successfully');
        		return redirect()->route('auditing.edit',$id);
        	}
        	else{

        		Session::flash('error','Record not Updated Successfully');
        		return redirect()->route('auditing.edit',$id);	
        	}
        	
        }
    }

    public function destroy($id)
    {
    	$recId = Auditing::findOrFail($id);

    	$recId->delete();
    	    	
    	if($recId){
    		Session::flash('message','Record deleted Successfully');
    		return redirect()->route('auditing.index');
    	}
    	else{
    		Session::flash('error','Record not deletd Successfully');
    		return redirect()->route('auditing.index');	
    	}
    }
}


