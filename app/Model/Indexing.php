<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Validator, Schema, Session;
use App\Model\PriorityType;
use App\Model\Region;
use App\Model\RequestType;
use App\Model\ContainerType;
use App\Model\Office;
use App\Library\TatCalculator;


class Indexing extends Model
{
    protected $table = 'indexing';
    public $columns  = [];

    protected $rules = [
    	'mail_received_dt'  => 'required',
     	'cust_name'   => 'required|min:2|max:255',
     	'request_no'  => 'required',
     	'priority_id' => 'required',
     	'region_id'   => 'required',
     	'req_type_id' => 'required',
     	'cont_type_id'=> 'required',
     	'office_id'   => 'required'
    ];

    protected $messages = [ //User defined message for errors
	    'mail_received_dt.required'	=> 'The mail received date field is required.',
	    'priority_id.required' 	=> 'The priority field is required.',
	 	'region_id.required'    => 'The region field is required.',
	 	'req_type_id.required'  => 'The requested type field is required.',
	 	'cont_type_id.required' => 'The container field is required.',
	 	'office_id.required'    => 'The office field is required.',
	];
	
/*Relationaships rule for indexing starts here*/    
	public function priority()
    {
    	return $this->belongsTo('App\Model\PriorityType','priority_id','id');

    }

    public function region()
    {
    	return $this->belongsTo('App\Model\Region','region_id','id');

    }

    public function requestType()
    {
    	return $this->belongsTo('App\Model\RequestType','req_type_id', 'id');

    }

    public function containerType()
    {
    	return $this->belongsTo('App\Model\ContainerType','cont_type_id','id');

    }

    public function office()
    {
    	return $this->belongsTo('App\Model\Office','office_id','id');

    }

    public function tat()
    {
        return $this->belongsTo('App\Model\Tat','priority_id','priority_id');

    }
	
    public function queryBy()
    {
        // first parameter is the name of the related class
        // second parameter is pivot table name
        return $this->belongsToMany('App\Model\UserAccess', 'process_queue', 'id', 'query_raised_by');
    }

    public function rfiType()
    {
        // first parameter is the name of the related class
        // second parameter is pivot table name
        return $this->belongsToMany('App\Model\RfiType', 'process_queue', 'id', 'rfiType_id');
    }


/*Relationaships rule for indexing ends here*/    
	
    public function validateIndexing(array $data)
    {
    	//dd($data);
    	return  Validator::make($data, $this->rules, $this->messages);
    	
    }

    public function saveIndexing(array $data, $id=null)
    {
    	//get all columns of current indexing

    	$columns = Schema::getColumnListing($this->table);

/****** automate save process getting all column names and text box name and save textbox value in columns ******/

    	// convert mail received date and time as mysql database  format before save
    	$data['mail_received_dt'] = date('Y-m-d H:i:s',strtotime($data['mail_received_dt']));

    	foreach ($data as $key => $value) {
    		if(in_array($key, $columns)){
    			$this->$key = $value;
    		}
    	}
    	
        //tat calculation
        $tat_cal = new TatCalculator();

        $priorityHrs = Tat::where('priority_id',$data['priority_id'])->get()->toArray()[0]['tat_time'];
      // dd($priorityHrs);
        $deadline = $tat_cal->calculateTat((int)$priorityHrs, $data['mail_received_dt']);
       
        $this->tat_after_index = $deadline;


    	//$this->mail_received_dt	= $data
        $this->indexed_by = Session::get('userId'); //id of login person
    	return $this->save();
    }

    public function updateIndexing(array $data, $id)
    {
    	//get all columns of current indexingl

    	$columns = Schema::getColumnListing($this->table);

/****** automate save process getting all column names and text box name and save textbox value in columns ******/
    	$obj = $this->find($id);

    	// convert mail received date and time as mysql database  format before save
    	$data['mail_received_dt'] = date('Y-m-d H:i:s',strtotime($data['mail_received_dt']));

    	//dd($obj);
    	foreach ($data as $key => $value) {
    		if(in_array($key, $columns)){
    			$obj->$key = $value;
    		}
    	}

        //tat calculation
        $tat_cal = new TatCalculator();

        $priorityHrs = Tat::where('priority_id',$data['priority_id'])->get()->toArray()[0]['tat_time'];
      // dd($priorityHrs);
        $deadline = $tat_cal->calculateTat((int)$priorityHrs, $data['mail_received_dt']);
       
        $obj->tat_after_index = $deadline;
        
    	return $obj->save();
    }

}
