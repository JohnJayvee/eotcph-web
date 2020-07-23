<?php

namespace App\Laravel\Middlewares\System;

use Closure, Helper,Str;
use App\Laravel\Models\{Department,ApplicationType,Application};

use App\Laravel\Models\{AccountCode};

class ExistRecord
{

    protected $reference_id;
    protected $module;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string $record
     * @return mixed
     */
    public function handle($request, Closure $next, $record)
    {
        $this->reference_id = $request->id;
        $module = "dashboard";
        $found_record = true;
        $previous_route = app('router')->getRoutes()->match(app('request')->create(url()->previous()))->getName();

        switch (strtolower($record)) {

            case 'application':
                if(! $this->__exist_application($request)) {
                    $found_record = false;
                    session()->flash('notification-status', "failed");
                    session()->flash('notification-msg', "No record found or resource already removed.");

                    $module = "account_code.index";
                }
            break;

            case 'application_type':
                if(! $this->__exist_application_type($request)) {
                    $found_record = false;
                    session()->flash('notification-status', "failed");
                    session()->flash('notification-msg', "No record found or resource already removed.");

                    $module = "application_type.index";
                }
            break;
            case 'department':
                if(! $this->__exist_department($request)) {
                    $found_record = false;
                    session()->flash('notification-status', "failed");
                    session()->flash('notification-msg', "No record found or resource already removed.");

                    $module = "department.index";
                }
            break;
            
        }

        if($found_record) {
            return $next($request);
        }
        no_record_found:
        return redirect()->route("system.{$module}");
    }

    private function __exist_application($request){
        $application = Application::find($this->reference_id);
        if($application){
            $request->merge(['application_data' => $application]);
            return TRUE;
        }

        return FALSE;
    }

    private function __exist_department($request){
        $department = Department::find($this->reference_id);

        if($department){
            $request->merge(['department_data' => $department]);
            return TRUE;
        }

        return FALSE;
    }

    private function __exist_application_type($request){
        $application_type = ApplicationType::find($this->reference_id);

        if($application_type){
            $request->merge(['application_type_data' => $application_type]);
            return TRUE;
        }

        return FALSE;
    }

}