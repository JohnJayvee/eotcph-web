<?php namespace App\Laravel\Requests\System;

use Session,Auth;
use App\Laravel\Requests\RequestManager;

class ApplicationRequest extends RequestManager{

	public function rules(){

		$rules = [
			'name' => "required",
			'department_id' => "required",
			'processing_fee' => "required",
			'processing_days' => "required",
			'requirements_id' => "required"
		];

		return $rules;
	}

	public function messages(){
		return [
			'required'	=> "Field is required.",
		];
	}
}