<?php

/*,'domain' => env("FRONTEND_URL", "wineapp.localhost.com")*/
Route::group(['as' => "web.",
		 'namespace' => "Web",
		 // 'domain' => env('SYSTEM_URL',''),
		],function() {

	
	Route::group(['prefix'=> "/",'as' => 'main.' ],function(){
		Route::get('/', [ 'as' => "index",'uses' => "MainController@index"]);
	});
	Route::get('type',['as' => "get_application_type",'uses' => "MainController@get_application_type"]);
	Route::get('amount',['as' => "get_payment_fee",'uses' => "MainController@get_payment_fee"]);
	Route::get('requirements',['as' => "get_requirements",'uses' => "MainController@get_requirements"]);
	Route::get('contact-us',['as' => "contact",'uses' => "MainController@contact"]);
	Route::any('logout',['as' => "logout",'uses' => "AuthController@destroy"]);

	Route::group(['middleware' => ["web","portal.guest"]], function(){
		Route::get('login/{redirect_uri?}',['as' => "login",'uses' => "AuthController@login"]);
        Route::post('login/{redirect_uri?}',['uses' => "AuthController@authenticate"]);
		Route::get('verify/{id?}',['as' => "verify",'uses' => "AuthController@verify"]);
        Route::post('verify/{id?}',['uses' => "AuthController@verified"]);

    /*  Route::get('forgot-password',['as' => "forgot_password",'uses' => "AuthController@forgot_pass"]);
        Route::post('change-password',['as' => "change_password",'uses' => "AuthController@change_password"]);*/
		Route::group(['prefix'=> "register",'as' => 'register.' ],function(){
            Route::get('/', [ 'as' => "index",'uses' => "AuthController@register"]);
            Route::post('/', [ 'uses' => "AuthController@store"]);
        });
	});

	Route::group(['middleware' => ["web","portal.auth"]], function(){
		Route::group(['prefix' => "transaction", 'as' => "transaction."], function () {
			Route::get('history',['as' => "history", 'uses' => "CustomerTransactionController@history"]);
			Route::get('show/{id?}',['as' => "show", 'uses' => "CustomerTransactionController@show"]);
			Route::get('create',['as' => "create", 'uses' => "CustomerTransactionController@create"]);
			Route::post('create',['uses' => "CustomerTransactionController@store"]);
		});
	});
		// Route::group(['prefix'=> "register",'as' => 'register.' ],function(){
  //           Route::get('/', [ 'as' => "index",'uses' => "AuthController@register"]);
  //           Route::post('/', [ 'uses' => "AuthController@store"]);
	 //     });
	
        // Route::post('login/{redirect_uri?}',['uses' => "AuthController@authenticate"]);
        // Route::get('forgot-password',['as' => "forgot_password",'uses' => "AuthController@forgot_pass"]);
        // Route::post('change-password',['as' => "change_password",'uses' => "AuthController@change_password"]);

		// $this->group(['prefix'=> "register",'as' => 'register.' ],function(){
  //           $this->get('/', [ 'as' => "index",'uses' => "AuthController@register"]);
  //           $this->post('/', [ 'uses' => "AuthController@store"]);
  //           $this->get('revert', [ 'as' => "revert",'uses' => "AuthController@revert"]);
  //       });
	


});