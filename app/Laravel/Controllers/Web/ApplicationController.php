<?php

namespace App\Laravel\Controllers\Web;

/*
 * Request Validator
 */
use App\Laravel\Requests\PageRequest;
use App\Laravel\Requests\Web\ApplicationRequest;
/*
 * Models
 */
use App\Laravel\Models\Application;
use App\Laravel\Models\Department;

/* App Classes
 */
use Carbon,Auth,DB,Str,ImageUploader;

class ApplicationController extends Controller
{
    protected $data;
	protected $per_page;
	
	public function __construct(){
		parent::__construct();
		array_merge($this->data, parent::get_data());
		$this->data['department'] = ['' => "Choose Department/Agency"] + Department::pluck('name', 'id')->toArray();
		
		$this->per_page = env("DEFAULT_PER_PAGE",10);
	}

		
	public function  create(PageRequest $request){
	
		$this->data['page_title'] = "E-Submission";
		return view('web.application.create',$this->data);
	}


	public function store(ApplicationRequest $request){

		DB::beginTransaction();
		try{
			
			$new_application = new Application;
			$new_application->fill($request->except('full_name'));
			$new_application->name = $request->get('full_name');
			$new_application->user_id = Auth::user()->id;
			$new_application->reference_code = 'PAY-'.str_pad(Auth::user()->id, 8, "0", STR_PAD_LEFT);
			
			if ($request->get('is_check')) {
				$new_application->is_copy_check = $request->get('is_check');
			}
			if($request->hasFile('file')) { 
			    $image = ImageUploader::upload($request->file('file'), "uploads/users");
			    $new_application->path = $image['path'];
			    $new_application->directory = $image['directory'];
			    $new_application->filename = $image['filename'];
			}
			$new_application->save();
			DB::commit();
			session()->flash('notification-status', "success");
			session()->flash('notification-msg','Successfully Submit Appliction.');
			return redirect()->route('web.application.create');
		}catch(\Exception $e){
			DB::rollback();
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
			return redirect()->back();
		}
	}

}
