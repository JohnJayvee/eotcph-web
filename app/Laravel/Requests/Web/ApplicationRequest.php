<?php namespace App\Laravel\Requests\Web;

use Session,Auth;
use App\Laravel\Requests\RequestManager;

class ApplicationRequest extends RequestManager{

	public function rules(){

		$id = $this->route('id')?:0;
		$rules = [
			'full_name' => "required",
			'company_name' => "required",
			'purpose' => "required",
			'department_id' => "required",
			'amount' => "required",
			'contact_number' => "required|max:10|phone:PH",
			'email'	=> "required",
            'file.*' => "required|file|mimes:pdf,jpeg,jpg,png,PNG,JPG,JPEG,docx,doc|max:204800",
		];

		
		return $rules;
	}

	public function messages(){
		return [
			'required'	=> "Field is required.",
			'contact_number.phone' => "Please provide a valid PH mobile number.",
			'file.required'	=> "No File Uploaded.",
			'mimes' => "Invalid attachment. Only allow PDF and image file format only.",

		];
	}
}