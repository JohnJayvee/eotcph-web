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
use Carbon,Auth,DB,Str;

class MainController extends Controller{

	protected $data;
	
	public function __construct(){
		parent::__construct();
		array_merge($this->data, parent::get_data());
	}

	public function dashboard(PageRequest $request){
		$auth = $request->user();
		$this->data['page_title'] .= " - Dashboard";

		$this->data['applications'] = Application::orderBy('created_at',"DESC")->get(); 
		$this->data['pending'] = Application::where('status',"pending")->count();
		$this->data['approved'] = Application::where('status',"approved")->count(); 
		$this->data['declined'] = Application::where('status',"declined")->count(); 
		$this->data['application_today'] = Application::whereDate('created_at', Carbon::now())->count(); 

		$chart_data = [];
		$per_month_date = [];
    	$per_month_application =[];

    	$approved_year_start = Carbon::now()->startOfYear()->subMonth();
    	$declined_year_start = Carbon::now()->startOfYear()->subMonth();
		foreach(range(1,12) as $index => $value){
			$approved = Application::whereRaw("MONTH(created_at) = '".$approved_year_start->addMonth()->format('m')."' AND YEAR(created_at) = '".Carbon::now()->format('Y')."'")->where('status','approved');
			$total_approved = $approved->count();

			$declined = Application::whereRaw("MONTH(created_at) = '".$declined_year_start->addMonth()->format('m')."' AND YEAR(created_at) = '".Carbon::now()->format('Y')."'")->where('status','declined');
			$total_declined = $declined->count();

			array_push($per_month_application, ["month"=>$approved_year_start->format("M"),"approved"=>$total_approved,"declined"=>$total_declined]);
			
		}



		$this->data['per_month_application'] = json_encode($per_month_application);
		array_push($chart_data,$this->data['approved'],$this->data['declined'],$this->data['pending']);
		$this->data['chart_data'] = json_encode($chart_data);
		return view('system.dashboard',$this->data);
	}


}