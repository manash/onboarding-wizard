<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => ['web']], function () {
	Route::get('/', array('as' => 'home', 'uses' => 'UserController@index'));
	Route::get('/login', array('as' => 'login', 'uses' => 'UserController@index'));
	Route::get('/register', array('as' => 'login', 'uses' => 'UserController@register'));


	Route::get('auth/login', 'Auth\AuthController@getLogin');
	Route::post('auth/login', 'Auth\AuthController@postLogin');
	Route::get('auth/logout', 'Auth\AuthController@getLogout');

	// Registration routes...
	Route::get('auth/register', 'Auth\AuthController@getRegister');
	Route::post('auth/register', 'Auth\AuthController@postRegister');

	Route::controllers([
		'password' => 'Auth\PasswordController',
	]);


	Route::get('user/get/{url}', array('as' => 'getUser', 'uses' => 'UserController@getUser'));
	Route::post('user/insert', array('as' => 'insertUser', 'uses' => 'UserController@insertUser'));

	Route::get('wizard/onboarding', array('as' => 'startOnboarding', 'uses' => 'StoreController@startOnboarding'));

	Route::post('wizard/addstore', array('as' => 'addStore', 'uses' => 'StoreController@addStore'));
	Route::post('wizard/additem', array('as' => 'addItem', 'uses' => 'StoreController@addStoreItem'));

	Route::get('wizard/dashboard', array('as' => 'dashboard', 'uses' => 'StoreController@dashboard'));

	Route::get('wizard/checkstorepresence/{url}', array('as' => 'checkStorePresence', 'uses' => 'StoreController@checkIfStorePresent'));
	Route::get('wizard/getstores', array('as' => 'getAllStores', 'uses' => 'StoreController@getAllStoreDetails'));
	Route::get('wizard/getstoresmenuitem/{url}', array('as' => 'getStoresMenuItem', 'uses' => 'StoreController@getStoreMenuItems'));

	Route::post('wizard/skipstep', array('as' => 'skipStep', 'uses' => 'StoreController@skipStep'));

	// Api Routes
	Route::get('api/checkstorepresence/{id}/{url}', array('uses' => 'ApiController@checkIfStorePresent'));
	Route::post('api/insertstore', array('uses' => 'ApiController@insertNewStore'));

	Route::get('api/checkitempresence/{id}/{url}', array('uses' => 'ApiController@checkIfStoreItemPresent'));
	Route::get('api/getallstoreitems/{id}', array('uses' => 'ApiController@getStoreMenuItems'));

});