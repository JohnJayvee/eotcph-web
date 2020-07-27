<?php 

namespace App\Laravel\Controllers\Web;

/*
 * Request Validator
 */

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;

use App\Laravel\Requests\PageRequest;
use App\Laravel\Requests\Web\RegisterRequest;

/*
 * Models
 */
use App\Laravel\Models\{Attendance,Employee,EmployeeLeaveCredit};
use App\Laravel\Models\User;

use App\Laravel\Listeners\SendCode;

use Carbon,Auth,DB,Str,ImageUploader,Event;

class AuthController extends Controller{

	protected $data;
	
	public function __construct(){
		parent::__construct();
		
	}

	public function login($redirect_uri = NULL){

		$this->data['page_title'] = " :: Login";
		return view('web.auth.login',$this->data);
	}
	public function authenticate($redirect_uri = NULL , PageRequest $request){
		try{
			$this->data['page_title'] = " :: Login";
			$username = $request->get('email');
			$password = $request->get('password');

			$field = filter_var($username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';	

			// $user = User::where($field,$username)->first();
			// if(!$user){
			// 	session()->flash('notification-status', "error");
			// 	session()->flash('notification-msg', "Invalid username/password");
			// 	return redirect()->back();
			// }
			
			if(Auth::attempt([$field => $username,'password' => $password])){
				$user = Auth::user();
				session()->put('auth_id', Auth::user()->id);
				session()->flash('notification-status','success');
				session()->flash('notification-msg',"Welcome to EOTC Portal, {$user->name}!");
				Auth::user()->save();
				if($redirect_uri AND session()->has($redirect_uri)){
					return redirect( session()->get($redirect_uri) );
				}
				return redirect()->route('web.application.create');
			}
			session()->flash('notification-status','error');
			session()->flash('notification-msg','Wrong username or password.');
			return redirect()->back();

		}catch(Exception $e){
			abort(500);
		}
	}

	public function register(){
		$this->data['page_title'] = " :: Create Account";
		return view('web.auth.registration',$this->data);
	}
	public function store(RegisterRequest $request){
		DB::beginTransaction();
		try{
			$new_user = new User;
			$new_user->fill($request->except('_token'));
			$new_user->type = "user";
			$new_user->password = bcrypt($request->get('password'));
			$new_user->code = SendCode::sendCode($request->get('contact_number'));
			$new_user->save();
			DB::commit();
			
			session()->flash('notification-status', "success");
			session()->flash('notification-msg','Verify your phone number.');
			return redirect()->route('web.verify',[$new_user->id]);
			
		}catch(\Exception $e){
			DB::rollback();
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
			return redirect()->back();
		}
			
	}
	public function verify(){
		$this->data['page_title'] = " :: Verify Account";
		return view('web.auth.verify',$this->data);

	}

	public function verified($id = NULL , PageRequest $request){
		
		$verified_user = User::where('id',$id)->where('code',$request->get('code'))->first();

		if ($verified_user) {
			User::where('id',$id)->update(['active' => "1"]);
			session()->flash('notification-status', "success");
			session()->flash('notification-msg','Your Account has been Successfully verified.');
			return redirect()->route('web.login');
		}
		else{
			Session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Verification Failed");
			return redirect()->back();
		}

	}
	public function destroy(){
		Auth::logout();
		session()->forget('auth_id');
		session()->flash('notification-status','success');
		session()->flash('notification-msg','You are now signed off.');
		return redirect()->route('web.login');
	}


}	
