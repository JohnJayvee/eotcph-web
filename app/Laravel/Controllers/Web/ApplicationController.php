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
use App\Laravel\Models\UserFile;


/* App Classes
 */
use App\Laravel\Events\SendReference;
use App\Laravel\Events\SendApplication;

use Carbon,Auth,DB,Str,ImageUploader,Event,FileUploader,PDF,QrCode;

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

			$temp_id = time();
			$auth_id = Auth::user()->id;

			
			$new_application = new Application;
			$new_application->fill($request->except('full_name'));
			$new_application->name = $request->get('full_name');
			$new_application->user_id = Auth::user()->id;
			$new_application->reference_code = 'PAY-'.str_pad(Auth::user()->id, 8, "0", STR_PAD_LEFT);
			
			if ($request->get('is_check')) {
				$new_application->is_copy_check = $request->get('is_check');
			}
			if($request->hasFile('file')) { 
				foreach ($request->file as $key => $image) {
					$ext = $image->getClientOriginalExtension();
					if($ext == 'pdf' || $ext == 'docx' || $ext == 'doc'){ 
						$type = 'file';
						$original_filename = $image->getClientOriginalName();
						$upload_image = FileUploader::upload($image, "uploads/documents/users/{$auth_id}");
					} elseif($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png'){ //gif,bmp
						$type = 'image';
						$original_filename = $image->getClientOriginalName();
						$upload_image = ImageUploader::upload($image, "uploads/images/users/{$auth_id}");
					}
					$new_file = new UserFile;
					$new_file->path = $upload_image['path'];
					$new_file->directory = $upload_image['directory'];
					$new_file->filename = $upload_image['filename'];
					$new_file->type =$type;
					$new_file->original_name =$original_filename;
					$new_file->application_id = $temp_id;
					$new_file->save();
				}
			}
			if ($new_application->save()) {
				UserFile::where('application_id',$temp_id)->update(['application_id' => $new_application->id]);
				$insert[] = [
		                'contact_number' => $new_application->contact_number,
		                'ref_num' => $new_application->reference_code
		            ];	
				$notification_data = new SendReference($insert);
			    Event::dispatch('send-sms', $notification_data);
				
				$insert_data[] = [
	                'email' => $new_application->email,
	                'name' => $new_application->name,
	                'company_name' => $new_application->company_name,
	                'department' => $new_application->department->name,
	                'purpose' => $new_application->type->name,
	                'ref_num' => $new_application->reference_code
	            ];	
				$application_data = new SendApplication($insert_data);
			    Event::dispatch('send-application', $application_data);

				session()->flash('notification-status', "success");
				session()->flash('notification-msg','Successfully Submit Application.');
				return redirect()->route('web.application.create');
			}
			
		
	}

	// public function pdf(){
	// 	QrCode::size(500)->format('png')->generate('HDTuto.com', public_path('web/img/qrcode.png'));

	// 	$this->data['qrcode'] =  QrCode::generate('MyNotePaper');
	// 	$pdf = PDF::loadView('emails.sample',$this->data)->setPaper('A4', 'portrait');
 //        return $pdf->stream('sample.pdf');
	// }

}
