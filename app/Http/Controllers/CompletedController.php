<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\ProcessQueue;
use App\Model\Indexing;
use App\Model\Auditing;

class CompletedController extends Controller
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
                                ->where("mst_status.status_name",'DONE')
                                ->orWhere("auditStat.status_name",'DONE')
                                ->get();
                        
                             //dd($auditings);
    				//dd($publishings);

		
    						//dd($publishings->toSql());

			


    			     	//dd($publishings);
    	return view('rfiQueue.completedView',compact('auditings'));
    }
}
