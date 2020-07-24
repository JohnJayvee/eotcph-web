<?php 

namespace App\Laravel\Controllers\System;

/*
 * Request Validator
 */
use App\Laravel\Requests\PageRequest;

/*
 * Models
 */
use App\Laravel\Models\Application;
/* App Classes
 */
use Carbon,Auth,DB,Str,ImageUploader;

class ApplicationsController extends Controller{

	protected $data;
	protected $per_page;
	
	public function __construct(){
		parent::__construct();
		array_merge($this->data, parent::get_data());
		
		$this->per_page = env("DEFAULT_PER_PAGE",10);
	}

	public function  index(PageRequest $request){
		$this->data['page_title'] = "Applications";
		$this->data['applications'] = Application::orderBy('created_at',"DESC")->get(); 
		return view('system.application.index',$this->data);
	}
	public function show(PageRequest $request,$id = NULL){
		
		$this->data['application'] = $request->get('application_data');
		$this->data['page_title'] = "Application Details";
		return view('system.application.show',$this->data);
	}
	
	public function process($id = NULL,PageRequest $request){
		DB::beginTransaction();
		try{

			$application = $request->get('application_data');
			$application->status = $request->get('status_type');
			$application->save();

			DB::commit();
			session()->flash('notification-status', "success");
			session()->flash('notification-msg', "Application has been successfully Processed.");
			return redirect()->route('system.application.index');
		}catch(\Exception $e){
			DB::rollback();
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
			return redirect()->back();
		}
	}

	public function  destroy(PageRequest $request,$id = NULL){
		$application = $request->get('application_data');
		DB::beginTransaction();
		try{
			$application->delete();
			DB::commit();
			session()->flash('notification-status', "success");
			session()->flash('notification-msg', "Barangay removed successfully.");
			return redirect()->route('system.barangay.index');
		}catch(\Exception $e){
			DB::rollback();
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
			return redirect()->back();
		}
	}

	
}