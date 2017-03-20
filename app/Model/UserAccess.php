<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Validator, Schema;

class UserAccess extends Model
{
    protected $table = 'mst_user_access';
    public $columns = [];

    protected $rules = [
     	'name'    => 'required|min:2|max:255',
     	'loginId' => 'required|unique:mst_user_access,loginId',
     	'access'  => 'required',
     	'email'   => 'required|email||unique:mst_user_access,email'
    ];

    
    public function access()
    {
        return $this->belongsTo('App\Model\Access','access_id','id');
    }

    public function validateUserAccess(array $data, $id=null)
    {
    	if($id)
        $this->rules = [
            'name'    => 'required|min:2|max:255',
            'loginId' => 'required|unique:mst_user_access,loginId,'.$id,
            'access_id'  => 'required',
            'email'   => 'required|email||unique:mst_user_access,email,'.$id
        ];            
    	return  Validator::make($data, $this->rules);
    	
    }

    public function saveUserAccess(array $data, $id=null)
    {
    	//get all columns of current userAccessl

    	$columns = Schema::getColumnListing($this->table);

/****** automate save process getting all column names and text box name and save textbox value in columns ******/
    	
    	foreach ($data as $key => $value) {
    		if(in_array($key, $columns)){
    			$this->$key = $value;
    		}
    	}
        
    	return $this->save();
    }

    public function updateUserAccess(array $data, $id)
    {
    	//get all columns of current userAccessl

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


