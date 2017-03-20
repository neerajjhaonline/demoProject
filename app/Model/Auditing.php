<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Validator, Schema, Session, DB;
use App\Model\ProcessQueue;
use App\Library\TatCalculator;

class Auditing extends Model
{
    protected $table = 'auditing';
    public $columns = [];

    protected $fillable = ['commodity_id'];


    protected $rules = [
    	'status_id'  => 'required',
    	/*'total_lane' => 'required|numeric',
    	'no_of_lane' => 'required|numeric',
    	'mode_id'    => 'required',*/
    ];


    public function tat()
    {
        return $this->belongsTo('App\Model\Tat');
    }

    public function indexing()
    {
        return $this->belongsTo('App\Model\Indexing');
    }

    public function rfiType()
    {
        return $this->belongsTo('App\Model\RfiType','rfiType_id', 'id');
    }

    public function errCat()
    {
        return $this->belongsTo('App\Model\ErrorCat','error_cat_id', 'id');
    }

    public function errType()
    {
        return $this->belongsTo('App\Model\ErrorType','error_type_id', 'id');
    }

    public function rfiDoneBy()
    {
        return $this->belongsTo('App\Model\userAccess','query_raised_by', 'id');
    }

    public function errorDoneBy()
    {
        return $this->belongsTo('App\Model\userAccess','error_done_by', 'id');
    }

    public function status()
    {
        return $this->belongsTo('App\Model\Status','status_id', 'id');
    }



    public function validateAuditing(array $data)
    {
    	
    	/*LOGIC FOR SETTING NEW VALIDATIN FOR COR REQUEST starts here*/
    	$ind = new Indexing();
    	$ind->req_type_id = $data['req_type_id']; 
    	if((strtoupper($ind->requestType->name) === 'COR') || $data['markError']){
    		$this->rules = [
		    	'status_id'  => 'required',
		    	/*'total_lane' => 'required|numeric',
		    	'no_of_lane' => 'required|numeric',
		    	'mode_id'    => 'required',*/
		    	'error_cat_id' => 'required',
		    	'error_type_id' => 'required',
		    	'correction' => 'required',
		    	'root_cause' => 'required',
		    	'corrective_action' => 'required',
		    	'preventive_action' => 'required',
		    	'proposed_comp_dt' => 'required',
		    	'proposed_act_dt' => 'required',
		    	'error_done_by' => 'required'
		    ];
    	} 

    	/*LOGIC FOR SETTING NEW VALIDATIN FOR COR REQUEST ends here*/


    	return  Validator::make($data, $this->rules);
    	
    }

    public function saveAuditing(array $data, $id=null)
    {
    	//get all columns of current model

    	$columns = Schema::getColumnListing($this->table);


/****** automate save process getting all column names and text box name and save textbox value in columns ******/

    	//$data['mode_id'] = json_encode($data['mode_id']);
		$data['audit_start_dt'] = date('Y-m-d H:i:s', strtotime($data['audit_start_dt']));
		
    	if(isset($data['proposed_act_dt']) || isset($data['proposed_comp_dt'])){
    		$data['proposed_act_dt'] = date('Y-m-d H:i:s',strtotime($data['proposed_act_dt']));
    		$data['proposed_comp_dt'] = date('Y-m-d H:i:s',strtotime($data['proposed_comp_dt']));
    	}

    

    	foreach ($data as $key => $value) {
    		if(in_array($key, $columns)){
    			$this->$key = $value;
    		}
    	}

      //  $this->publish_by = Session::get('userId');
        //$this->publish_start_dt = date("Y-m-d H:i:s");

        /*calculating TAT*/

        $tat_cal = new TatCalculator();
        $deadline = $tat_cal->calculateTat($data['priorityHrs'], $data['mail_received_dt']);
        $this->tat = $deadline;
        

        /*calculating TAT*/
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    	return $this->save();
       // DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    public function updateAuditing(array $data, $id)
    {
    	//get all columns of current model
    	$columns = Schema::getColumnListing($this->table);

/****** automate save process getting all column names and text box name and save textbox value in columns ******/
        //$data['mode_id'] = json_encode($data['mode_id']);

        if(isset($data['proposed_act_dt']) || isset($data['proposed_comp_dt'])){
            $data['proposed_act_dt'] = date('Y-m-d H:i:s',strtotime($data['proposed_act_dt']));
            $data['proposed_comp_dt'] = date('Y-m-d H:i:s',strtotime($data['proposed_comp_dt']));
        }

    	$obj = $this->find($id);

    	//dd($obj);
    	foreach ($data as $key => $value) {
    		if(in_array($key, $columns)){
    			$obj->$key = $value;
    		}
    	}

        $obj->publish_by = Session::get('userId');

        if(in_array($obj->status->status_name, array('SENT TO AUDIT','DONE','DISREGARD'))) //if status is in mentioned array then publish request stops
            $obj->audit_end_dt = date("Y-m-d H:i:s");//capture publish end time

        if(strtoupper($obj->status->status_name) === 'PENDING IN') 
            $obj->rfi_start_dt = date("Y-m-d H:i:s");//capture rfi start time


        $tat_cal = new TatCalculator();
        $deadline = $tat_cal->calculateTat((int)$data['priorityHrs'], $data['mail_received_dt']);
       
        $obj->tat = $deadline;


        if(strtoupper($obj->status->status_name) === 'PENDING OUT'){
            $pOut = date("Y-m-d H:i:s");
            $obj->rfi_end_dt = $pOut;//capture rfi end time
            $after_rfi = $tat_cal->rfiDeadline($data['pIn'],$pOut,$deadline);
            $obj->tat = $after_rfi;
        }



    	return $obj->save();
    }


}



