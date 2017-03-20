<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'LdapController@index');



Route::auth();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/home', function(){
	return View('errors.notPermitted');
})->name('503');



Route::post('/auth/login', 'LdapController@checkLogin');

/*============================================================================================*/
//master routes starts here
Route::group(['middleware'=>['ldap','role:admin']],function(){
	Route::get('admin', 'DashboardController@index');
	Route::resource('office', 'OfficeController');
	Route::resource('userAccess', 'UserAccessController');
	Route::resource('holiday', 'HolidayController');
	Route::resource('region', 'RegionController');
	Route::resource('requestType', 'RequestTypeController');
	Route::resource('containerType', 'ContainerTypeController');
	Route::resource('errorType', 'ErrorTypeController');
	Route::resource('priorityType', 'PriorityTypeController');
	Route::resource('errorCat', 'ErrorCatController');
	Route::resource('mode', 'ModeController');
	Route::resource('tat', 'TatController');
	Route::resource('indexing', 'IndexingController');
	Route::resource('statusCat', 'StatusCatController');
	Route::resource('status', 'StatusController');
	Route::resource('commodity', 'CommodityController');
	Route::resource('rfiType', 'RfiTypeController');
	

	//Route::get('/logout', 'LdapController@logOut');
});

Route::group(['middleware'=>['ldap','role:auditor']],function(){
	Route::resource('auditing', 'AuditingController');
	Route::resource('publishing', 'PublishingController');
	Route::get('rfi', 'RfiController@index')->name('rfi.view');
	Route::get('completed', 'CompletedController@index')->name('completed.view');
	Route::post('reqNum','IndexingController@requestNumber');
});

Route::get('/logout', 'LdapController@logOut');
//Route::get('office/edit/{id}', 'OfficeController@edit')->name('master.office.edit');
//Route::patch('office/update', 'OfficeController@update')->name('master.office.update');


/*Route::get('office/create', function () {
    return view('masters.office.officeCreate');
});

Route::post('office/create', 'OfficeController@save');*/
//master routes ends here

/*============================================================================================*/