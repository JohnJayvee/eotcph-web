<?php 
namespace App\Laravel\Events;

use Illuminate\Queue\SerializesModels;
use Mail,Str,Helper,Carbon,Nexmo;

class SendDeclinedReference extends Event {


	use SerializesModels;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct(array $form_data)
	{
		$this->data = $form_data;
		// $this->email = $form_data['insert'];

	

	}

	public function job(){	
		
		
		foreach($this->data as $index =>$value){
			$phone = $value['contact_number'];
			$ref_num = $value['ref_num'];
			$full_name = $value['full_name'];
			$department_name = $value['department_name'];
			$application_name = $value['application_name'];
			$modified_at = $value['modified_at'];
			$remarks = $value['remarks'];

			$nexmo = Nexmo::message()->send([
				'to' => '+63'.(int)$phone,
				'from' => 'EOTCPH' ,
				'text' => "Hello " . $full_name . "\r\n\n Good day. We have processed your application, and we regret to inform you that your application has been declined by our processor. \r\n\n Below are your transaction details: \r\nApplication: ".$application_name."\r\n Department: ".$department_name."\r\n Date: ".$modified_at."\r\n Remarks: ".$remarks."\r\n\n Don't worry, you can still resubmit your application. Please click this link to download your reference number <PDF link here> and attached it to your physical documents and send it to our office.\r\n\nThank you for choosing EOTC-PHP!"

,
			]);
			
		}


		
		
		
	}
}