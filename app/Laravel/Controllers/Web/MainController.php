<?php 

namespace App\Laravel\Controllers\Web;

/*
 * Request Validator
 */
use App\Laravel\Requests\PageRequest;
use App\Laravel\Models\ApplicationType;
/*
 * Models
 */

/* App Classes
 */
use Helper, Carbon, Session, Str,Auth,Input,DB;

class MainController extends Controller{

	protected $data;
	public function __construct () {
	}


	public function index(PageRequest $request){
		$this->data['page_title'] = "Homepage";
		return view('web.homepage',$this->data);
	}

	public function contact(PageRequest $request){
		$this->data['page_title'] = "Contact Us";
		return view('web.page.contact',$this->data);
	}
	public function application(PageRequest $request){
		$this->data['page_title'] = "Application";

		return view('web.page.application',$this->data);
	}


	public function get_application_type(PageRequest $request){
		$id = $request->get('department_id');
		$application_type = ApplicationType::where('department_id',$id)->get()->pluck('name', 'id');
		$response['msg'] = "List of ApplicationType";
		$response['status_code'] = "TYPE_LIST";
		$response['data'] = $application_type;
		callback:


		return response()->json($response, 200);
	}

}