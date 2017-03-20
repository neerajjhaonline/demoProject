<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Validator, Schema;

class Commodity extends Model
{
    protected $table = 'mst_commodity';
    public $columns = [];

    protected $rules = [
    	'type'  => 'required|min:2|max:255',
    	'commodity_name'  => 'required|min:2|max:255',
    ];

    
    public function validateCommodity(array $data)
    {
    	
    	return  Validator::make($data, $this->rules);
    	
    }

    public function saveCommodity(array $data, $id=null)
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

    public function updateCommodity(array $data, $id)
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


