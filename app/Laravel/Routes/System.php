<?php

/*,'domain' => env("FRONTEND_URL", "wineapp.localhost.com")*/
Route::group(['as' => "system.",
		 'namespace' => "System",
		 'middleware' => ["web"],
		 // 'domain' => env('SYSTEM_URL',''),
		 'prefix' => "admin"
		],function() {



Route::group(['as' => "auth."], function(){
		Route::get('login/{uri?}',['as' => "login",'uses' => "AuthController@login","middleware" => "system.guest"]);
		Route::post('login/{uri?}',['uses' => "AuthController@authenticate","middleware" => "system.guest"]);
		Route::get('register', [ 'as' => "register",'uses' => "AuthController@register","middleware" => "system.guest"]);
		Route::post('register', [ 'uses' => "AuthController@store","middleware" => "system.guest"]);
		Route::get('logout',['as' => "logout",'uses' => "AuthController@logout","middleware" => "system.auth"]);
		Route::any('get-municipalities',['as' => "get_municipalities", 'uses' => "AuthController@get_municipalities"]);
	});
	Route::group(['middleware' => "system.auth"],function(){
		Route::get('/',['as' => "dashboard",'uses' => "MainController@dashboard"]);

		Route::group(['as' => "application.",'prefix' => "application"], function(){
			Route::get('/',['as' => "index",'uses' => "ApplicationsController@index"]);
			Route::get('show/{id?}',['as' => "show",'uses' => "ApplicationsController@show",'middleware' => "system.exist:application"]);
			Route::get('process/{id?}',['as' => "process",'uses' => "ApplicationsController@process",'middleware' => "system.exist:application"]);
			Route::any('delete/{id?}',['as' => "destroy",'uses' => "ApplicationsController@destroy"]);
		});

		Route::group(['as' => "profile.",'prefix' => "profile"], function(){
			Route::get('/',['as' => "index",'uses' => "ProfileController@index"]);
			Route::get('edit',['as' => "edit",'uses' => "ProfileController@edit"]);
			Route::post('edit',['uses' => "ProfileController@update"]);
			Route::post('image',['as' => "image.edit",'uses' => "ProfileController@update_image"]);
			Route::get('password',['as' => "password.edit",'uses' => "ProfileController@edit_password"]);
			Route::post('password',['uses' => "ProfileController@update_password"]);
		});

		Route::group(['as' => "department.",'prefix' => "department"], function(){
			Route::get('/',['as' => "index",'uses' => "DepartmentController@index"]);
			Route::get('create',['as' => "create",'uses' => "DepartmentController@create"]);
			Route::post('create',['uses' => "DepartmentController@store"]);
			Route::get('edit/{id?}',['as' => "edit",'uses' => "DepartmentController@edit",'middleware' => "system.exist:department"]);
			Route::post('edit/{id?}',['uses' => "DepartmentController@update",'middleware' => "system.exist:department"]);
			Route::any('delete/{id?}',['as' => "destroy",'uses' => "DepartmentController@destroy",'middleware' => "system.exist:department"]);
			
		});

		Route::group(['as' => "application_type.",'prefix' => "application-type"], function(){
			Route::get('/',['as' => "index",'uses' => "ApplicationTypeController@index"]);
			Route::get('create',['as' => "create",'uses' => "ApplicationTypeController@create"]);
			Route::post('create',['uses' => "ApplicationTypeController@store"]);
			Route::get('edit/{id?}',['as' => "edit",'uses' => "ApplicationTypeController@edit",'middleware' => "system.exist:application_type"]);
			Route::post('edit/{id?}',['uses' => "ApplicationTypeController@update",'middleware' => "system.exist:application_type"]);
			Route::any('delete/{id?}',['as' => "destroy",'uses' => "ApplicationTypeController@destroy",'middleware' => "system.exist:application_type"]);
			
		});
	});

	


});