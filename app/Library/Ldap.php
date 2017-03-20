<?php
namespace App\Library;
use Session, Validator;
use App\Model\UserAccess;
 
class Ldap 
{
  private  $ldap = false;
  protected $rules = [
        'username' => 'required|min:2|max:255',
        'password' => 'required'
  ];

  public function validateLdap($request)
  {
       
      return $valid = Validator::make($request->all(), $this->rules);
      
  }

  public function checkLdap($username,$password)
  {
  	  $ldaprdn="inchessc\\".$username;
  	  $ldapconn=ldap_connect('10.13.60.7');
      
      if ($ldapconn) {
    	  
        $ldapbind = @ldap_bind($ldapconn, $ldaprdn, $password);

        $unauth =  UserAccess::where('loginId', $username)->first();

      	if (($ldapbind) && ($password != '') && ($unauth !== null)) {
      		
          Session::put('ldap','access');
          Session::put('uName',$username);
          Session::put('userId',$unauth->id);
          Session::put('userAccess',$unauth->access->name);

       //   dd(Session::get('userId'));
          $this->ldap = true;
      	} else {
      		Session::forget('ldap');
          Session::forget('uName');
          $this->ldap = false;
      	}
    	
      }

      ldap_close($ldapconn);
      return $this->ldap;
  }
}
