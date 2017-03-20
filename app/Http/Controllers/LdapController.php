<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Library\Ldap;
use Validator, Session;

class LdapController extends Controller
{
    public function index()
    {
        if(Session::has('ldap'))
           return redirect('/admin');        
        else
           return view('auth.login');

    }

    public function checkLogin(Request $request)
    {
    	
    	$ldap = new Ldap();
 	  	$valid = $ldap->validateLdap($request);
   		
      if($valid->fails()){

        	return redirect('/')
                    ->withErrors($valid)
                    ->withInput();
    
   		}

   		$result = $ldap->checkLdap($request->username,$request->password);
   		//dd($result,$request->username,$request->password);
      $userAccess = Session::get('userAccess');
   		if($result){

        if($userAccess === 'admin' || $userAccess === 'superadmin')
   			  return redirect('/admin');
        else if($userAccess === 'auditor')
          return redirect()->route('auditing.index');
        else if($userAccess === 'user')
          return redirect()->route('indexing.create');
      }

    	Session::flash('error','Users Invalid Credential');
     	return redirect('/');
        
    
    }

    public function logOut() 
    {

     	  Session::forget('ldap');
        Session::forget('uName');
        return redirect('/');

	 }
}
