<?php 

namespace App\Laravel\Controllers\System;

/*
 * Request Validator
 */
use App\Laravel\Requests\PageRequest;

/*
 * Models
 */
use App\Laravel\Models\Transaction;
use App\Laravel\Models\TransactionRequirements;
use App\Laravel\Events\SendApprovedReference;
use App\Laravel\Events\SendDeclinedReference;
/* App Classes
 */
use Carbon,Auth,DB,Str,ImageUploader,Helper,Event;

class TransactionController extends Controller{

	protected $data;
	protected $per_page;
	
	public function __construct(){
		parent::__construct();
		array_merge($this->data, parent::get_data());
		
		$this->per_page = env("DEFAULT_PER_PAGE",10);
	}

	public function  index(PageRequest $request){
		$this->data['page_title'] = "Transactions";
		$this->data['transactions'] = Transaction::orderBy('created_at',"DESC")->get(); 
		return view('system.transaction.index',$this->data);
	}
	public function show(PageRequest $request,$id = NULL){
		$this->data['count_file'] = TransactionRequirements::where('transaction_id',$id)->count();
		$this->data['attachments'] = TransactionRequirements::where('transaction_id',$id)->get();
		$this->data['transaction'] = $request->get('transaction_data');

		$this->data['page_title'] = "Transaction Details";
		return view('system.transaction.show',$this->data);
	}
	
	public function process($id = NULL,PageRequest $request){
		$type = strtoupper($request->get('status_type'));
		DB::beginTransaction();
		try{
			$transaction = $request->get('transaction_data');
			$transaction->status = $type;
			$transaction->amount = $type == "APPROVED" ? $request->get('amount') : NULL;
			$transaction->remarks = $type == "DECLINED" ? $request->get('remarks') : NULL;
			$transaction->processor_user_id = Auth::user()->id;
			$transaction->modified_at = Carbon::now();
			$transaction->save();

			if ($type == "APPROVED") {
				$insert[] = [
	            	'contact_number' => $transaction->contact_number,
	                'ref_num' => $transaction->transaction_code,
	                'amount' => $transation->amount
            	];	

				$notification_data = new SendApprovedReference($insert);
			    Event::dispatch('send-sms-approved', $notification_data);
			}
			if ($type == "DECLINED") {
				$insert[] = [
	            	'contact_number' => $transaction->contact_number,
	                'ref_num' => $transaction->processing_fee_code,
	                'remarks' => $transaction->remarks,
	                'full_name' => $transaction->customer->full_name,
	                'application_name' => $transaction->application_name,
	                'department_name' => $transaction->department_name,
	                'modified_at' => Helper::date_only($transaction->modified_at)
            	];	

				$notification_data = new SendDeclinedReference($insert);
			    Event::dispatch('send-sms-declined', $notification_data);
			}
			

			DB::commit();
			session()->flash('notification-status', "success");
			session()->flash('notification-msg', "Transaction has been successfully Processed.");
			return redirect()->route('system.transaction.index');
		}catch(\Exception $e){
			DB::rollback();
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
			return redirect()->back();
		}
	}

	public function process_requirements($id = NULL,$status = NULL,PageRequest $request){
		DB::beginTransaction();
		
		try{
			$transaction = TransactionRequirements::find($id);
			$transaction->status = $request->get('status');
			$transaction->save();

			DB::commit();
			session()->flash('notification-status', "success");
			session()->flash('notification-msg', "Requirements has been successfully ".$request->get('status').".");
			return redirect()->route('system.transaction.show',[$transaction->transaction_id]);
		}catch(\Exception $e){
			DB::rollback();
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
			return redirect()->back();
		}
	}

	public function  destroy(PageRequest $request,$id = NULL){
		$transaction = $request->get('transaction_data');
		DB::beginTransaction();
		try{
			$transaction->delete();
			DB::commit();
			session()->flash('notification-status', "success");
			session()->flash('notification-msg', "Transaction removed successfully.");
			return redirect()->route('system.barangay.index');
		}catch(\Exception $e){
			DB::rollback();
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
			return redirect()->back();
		}
	}

	
}