<?php 

namespace App\Laravel\Controllers\System;


/*
 * Models
 */
use App\Laravel\Models\Region;
use App\Laravel\Models\City;
use App\Laravel\Models\User;


/*
 * Request Validator
 */
use App\Laravel\Requests\PageRequest;
use App\Laravel\Requests\System\AdminRequest;


use Carbon,Auth,DB,Str,Socialize;

class AuthController extends Controller{

	protected $data;
	
	public function __construct(){
		parent::__construct();
		$this->data['regions'] = ['' => '--Select Region--'] + Region::pluck('regDesc', 'regCode')->toArray();
		$this->data['cities'] = ['' => '--Select City--'];
		array_merge($this->data, parent::get_data());
	}

	public function login(){
		$this->data['page_title'] .=  " :: Login";
		
		return view('system.auth.login',$this->data);
	}

	public function authenticate(PageRequest $request,$uri = NULL){

		$password = $request->get('password');
		$username = Str::lower($request->get('username'));
		$remember_me = $request->get('remember_me',0);
		$field = filter_var($username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

		if(Auth::attempt([$field => $username,'password' => $password],$remember_me)){
			// dd(Auth::user());exit;
			$account = Auth::user();

			if(Str::lower($account->status) != "active"){
				Auth::logout();
				session()->flash('notification-status','info');
				session()->flash('notification-msg','Account locked. Access to system was removed.');
				return redirect()->route('system.auth.login');
			}

			if(in_array($account->type,['user'])){

				Auth::logout();
				session()->flash('notification-status','info');
            	session()->flash('notification-msg',"You don't have enough access to the requested page.");
				
				return redirect()->route('system.auth.login');
			}
			

			$account->last_login_at = Carbon::now();
			$account->save();

			session()->put('auth_id',$account->id);


			if($uri AND session()->has($uri)){
				session()->flash('notification-status','success');
				session()->flash('notification-msg',"Welcome {$account->name}!");
				return redirect( session()->get($uri) );
			}

			session()->flash('notification-status','success');
			session()->flash('notification-msg',"Welcome {$account->name}!");
			return redirect()->route('system.dashboard');
		}

		session()->flash('notification-status','failed');
		session()->flash('notification-msg','Invalid account credentials.');
		return redirect()->back();
	}


	public function logout(){
		Auth::logout();
		session()->forget('auth_id');
		session()->flash('notification-status', "success");
		session()->flash('notification-msg','You are now signed off.');
		return redirect()->route('system.auth.login');
	}

	public function register(){
		$this->data['page_title'] = " :: Create Processor Account";
		return view('system.auth.registration',$this->data);
	}

	public function store(AdminRequest $request){
			
		DB::beginTransaction();
		try{
			$new_admin = new User;
			$new_admin->fill($request->except('_token'));
			$new_admin->type = "admin";
			$new_admin->region = $request->get('region');
			$new_admin->city = $request->get('city');
			$new_admin->barangay = $request->get('barangay');
			$new_admin->street_name = $request->get('street_name');
			$new_admin->unit_number = $request->get('unit_number');
			$new_admin->zipcode = $request->get('zipcode');
			$new_admin->birthdate = $request->get('birthdate');
			$new_admin->tin_no = $request->get('tin_no');
			$new_admin->sss_no = $request->get('sss_no');
			$new_admin->phic_no = $request->get('phic_no');
			$new_admin->password = bcrypt($request->get('password'));
			$new_admin->save();
			DB::commit();
			session()->flash('notification-status', "success");
			session()->flash('notification-msg','Successfully registered.');
			return redirect()->route('web.login');
		}catch(\Exception $e){
			DB::rollback();
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
			return redirect()->back();
		}
	}

	public function get_municipalities(PageRequest $request){
		$id = $request->get('id');
		$cities = City::where('regDesc', $id)->get();
		return response()->json($cities);
	}
}