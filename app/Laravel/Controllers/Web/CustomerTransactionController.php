<?php

namespace App\Laravel\Controllers\Web;

/*
 * Request Validator
 */
use App\Laravel\Requests\PageRequest;
use App\Laravel\Requests\Web\TransactionRequest;
/*
 * Models
 */
use App\Laravel\Models\Transaction;
use App\Laravel\Models\Department;
use App\Laravel\Models\ZoneLocation;
use App\Laravel\Models\ApplicationRequirements;
use App\Laravel\Models\Application;
use App\Laravel\Models\TransactionRequirements;


/* App Classes
 */
use App\Laravel\Events\SendReference;
use App\Laravel\Events\SendApplication;

use Carbon,Auth,DB,Str,ImageUploader,Event,FileUploader,PDF,QrCode;

class CustomerTransactionController extends Controller
{
    protected $data;
	protected $per_page;
	
	public function __construct(){
		parent::__construct();
		array_merge($this->data, parent::get_data());
		$this->data['department'] = ['' => "Choose Peza Unit"] + Department::pluck('name', 'id')->toArray();
		$this->data['zone_locations'] = ['' => "Choose Zone Location"] + ZoneLocation::pluck('ecozone', 'id')->toArray();
		$this->per_page = env("DEFAULT_PER_PAGE",10);
	}

		
	public function create(PageRequest $request){
		
		$this->data['page_title'] = "E-Submission";
		return view('web.transaction.create',$this->data);
	}


	public function store(TransactionRequest $request){

		$temp_id = time();
		$auth_id = Auth::guard('customer')->user()->id;
		$ref = Transaction::withTrashed()->latest('id')->first();
		$ref_id =  $ref ? $ref->id : 0 ;

		$requirements = Application::where('id',$request->get('application_id'))->first();
		$count = ApplicationRequirements::whereIn('id',explode(",", $requirements->requirements_id))->count();

		if (count($request->file) < $count) {
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "You must at least submit the minimum requirements needed.");
			return redirect()->back();
		}
		DB::beginTransaction();
		try{
			$new_transaction = new Transaction;
			$new_transaction->company_name = $request->get('company_name');
			$new_transaction->email = $request->get('email');
			$new_transaction->contact_number = $request->get('contact_number');
			$new_transaction->zone_id = $request->get('zone_id');
			$new_transaction->zone_name = $request->get('zone_name');
			$new_transaction->customer_id = $auth_id;
			$new_transaction->processing_fee = $request->get('processing_fee');
			$new_transaction->application_id = $request->get('application_id');
			$new_transaction->application_name = $request->get('application_name');
			$new_transaction->department_id = $request->get('department_id');
			$new_transaction->department_name = $request->get('department_name');
			$new_transaction->code = 'EOTC-'.str_pad($ref_id + 1, 8, "0", STR_PAD_LEFT);
			$new_transaction->processing_fee_code = 'PF-'.str_pad($ref_id + 1, 8, "0", STR_PAD_LEFT);
			$new_transaction->transaction_code = 'APP-'.str_pad($ref_id + 1, 8, "0", STR_PAD_LEFT);

			if ($request->get('is_check')) {
				$new_transaction->is_printed_requirements = $request->get('is_check');
				$new_transaction->document_reference_code = 'EOTC-DOC-'.str_pad($ref_id + 1	, 8, "0", STR_PAD_LEFT);
			}
			if($request->hasFile('file')) { 
				foreach ($request->file as $key => $image) {
					$ext = $image->getClientOriginalExtension();
					if($ext == 'pdf' || $ext == 'docx' || $ext == 'doc'){ 
						$type = 'file';
						$original_filename = $image->getClientOriginalName();
						$upload_image = FileUploader::upload($image, "uploads/documents/transaction/{$new_transaction->transaction_code}");
					} 
					$new_file = new TransactionRequirements;
					$new_file->path = $upload_image['path'];
					$new_file->directory = $upload_image['directory'];
					$new_file->filename = $upload_image['filename'];
					$new_file->type =$type;
					$new_file->original_name =$original_filename;
					$new_file->transaction_id = $temp_id;
					$new_file->save();
				}
			}
			if ($new_transaction->save()) {
				DB::commit();
				TransactionRequirements::where('transaction_id',$temp_id)->update(['transaction_id' => $new_transaction->id]);
				$insert[] = [
		                'contact_number' => $new_transaction->contact_number,
		                'ref_num' => $new_transaction->code
		            ];	
				$notification_data = new SendReference($insert);
			    Event::dispatch('send-sms', $notification_data);
				
				// $insert_data[] = [
	   //              'email' => $new_transaction->email,
	   //              'name' => $new_transaction->customer->full_name,
	   //              'company_name' => $new_transaction->company_name,
	   //              'department' => $new_transaction->department->name,
	   //              'purpose' => $new_transaction->type->name,
	   //              'ref_num' => $new_transaction->code
	   //          ];	
				// $application_data = new SendApplication($insert_data);
			 //    Event::dispatch('send-application', $application_data);

				session()->flash('notification-status', "success");
				session()->flash('notification-msg','Successfully Submit Application.');
				return redirect()->route('web.transaction.create');
			}
		}catch(\Exception $e){
			DB::rollback();
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
			return redirect()->back();

		}
		
			
		
	}
	public function history(){
		$auth_id = Auth::guard('customer')->user()->id;

		$this->data['transactions'] = Transaction::where('customer_id', $auth_id)->orderBy('created_at',"DESC")->get();
		$this->data['page_title'] = "Application history";
		return view('web.transaction.history',$this->data);

	}

	public function show($id = NULL){
		$this->data['transaction'] = Transaction::find($id);
		$this->data['page_title'] = "Application Details";
		return view('web.transaction.show',$this->data);

	}
	// public function pdf(){
	// 	QrCode::size(500)->format('png')->generate('HDTuto.com', public_path('web/img/qrcode.png'));

	// 	$this->data['qrcode'] =  QrCode::generate('MyNotePaper');
	// 	$pdf = PDF::loadView('emails.sample',$this->data)->setPaper('A4', 'portrait');
 //        return $pdf->stream('sample.pdf');
	// }

}
