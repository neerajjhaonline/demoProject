<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Validator, Schema;

class Status extends Model
{
    protected $table = 'mst_status';
    public $columns = [];

    protected $rules = [
    	'status_name'  => 'required|min:2|max:255',
    ];

    public function statusCat()
    {
        return $this->belongsTo('App\Model\StatusCat','statusCatId','id');

    }

    public function indexing()
    {
        return $this->belongsTo('App\Indexing');
    }

    public function validateStatus(array $data)
    {
    	
    	return  Validator::make($data, $this->rules);
    	
    }

    public function saveStatus(array $data, $id=null)
    {
    	//get all columns of current model

    	$columns = Schema::getColumnListing($this->table);

/****** automate save process getting all column names and text box name and save textbox value in columns ******/
    	
    	foreach ($data as $key => $value) {
    		if(in_array($key, $columns)){
    			$this->$key = $value;
    		}
    	}
        
    	return $this->save();
    }

    public function updateStatus(array $data, $id)
    {
    	//get all columns of current model

    	$columns = Schema::getColumnListing($this->table);

/****** automate save process getting all column names and text box name and save textbox value in columns ******/
    	$obj = $this->find($id);
    	//dd($obj);
    	foreach ($data as $key => $value) {
    		if(in_array($key, $columns)){
    			$obj->$key = $value;
    		}
    	}
        
    	return $obj->save();
    }




}


