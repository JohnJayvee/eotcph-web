<?php

namespace App\Laravel\Controllers\System;

/*
 * Request Validator
 */
use App\Laravel\Requests\PageRequest;
use App\Laravel\Requests\System\ApplicationTypeRequest;
/*
 * Models
 */
use App\Laravel\Models\ApplicationType;
use App\Laravel\Models\Department;
/* App Classes
 */
use Carbon,Auth,DB,Str;

class ApplicationTypeController extends Controller
{
    protected $data;
	protected $per_page;
	
	public function __construct(){
		parent::__construct();
		array_merge($this->data, parent::get_data());
		$this->data['department'] = ['' => "All Department/Agency"] + Department::pluck('name','id')->toArray();
		$this->per_page = env("DEFAULT_PER_PAGE",10);
	}

	public function  index(PageRequest $request){
		$this->data['page_title'] = "Application Type";
		$this->data['application_types'] = ApplicationType::orderBy('created_at',"DESC")->get(); 
		return view('system.application-type.index',$this->data);
	}

	public function  create(PageRequest $request){
		$this->data['page_title'] .= " - Add new record";
		return view('system.application-type.create',$this->data);
	}
	public function store(ApplicationTypeRequest $request){
		DB::beginTransaction();
		try{
			$new_application_type = new ApplicationType;
			$new_application_type->department_id = $request->get('department_id');
			$new_application_type->name = $request->get('name');
			$new_application_type->save();
			DB::commit();
			session()->flash('notification-status', "success");
			session()->flash('notification-msg', "New Application Type has been added.");
			return redirect()->route('system.application_type.index');
		}catch(\Exception $e){
			DB::rollback();
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
			return redirect()->back();
		}
	}

	public function  edit(PageRequest $request,$id = NULL){
		$this->data['page_title'] .= " - Edit record";
		$this->data['application_type'] = $request->get('application_type_data');
		return view('system.application-type.edit',$this->data);
	}

	public function  update(ApplicationTypeRequest $request,$id = NULL){
		DB::beginTransaction();
		try{

			$application_type = $request->get('application_type_data');
			$application_type->name = $request->get('name');
			$application_type->department_id = $request->get('department_id');
			$application_type->save();

			DB::commit();
			session()->flash('notification-status', "success");
			session()->flash('notification-msg', "Application Type had been modified.");
			return redirect()->route('system.application_type.index');
		}catch(\Exception $e){
			DB::rollback();
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
			return redirect()->back();
		}
	}

	

	public function  destroy(PageRequest $request,$id = NULL){
		$application_type = $request->get('application_type_data');
		DB::beginTransaction();
		try{
			$application_type->delete();
			DB::commit();
			session()->flash('notification-status', "success");
			session()->flash('notification-msg', "Application Type removed successfully.");
			return redirect()->route('system.application_type.index');
		}catch(\Exception $e){
			DB::rollback();
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
			return redirect()->back();
		}
	}
}
