<?php namespace App\Laravel\Requests\Web;

use Session,Auth;
use App\Laravel\Requests\RequestManager;

class RegisterRequest extends RequestManager{

	public function rules(){

		$id = $this->route('id')?:0;
		$rules = [
			'fname' => "required",
			'lname' => "required",
			'contact_number' => "required|max:10|phone:PH",
			'email'	=> "required|unique:user,email,{$id}",
			'password'	=> "required|confirmed",

		];
		
		return $rules;
	}

	public function messages(){
		return [
			'required'	=> "Field is required.",
			'contact_number.phone' => "Please provide a valid PH mobile number.",
		];
	}
}