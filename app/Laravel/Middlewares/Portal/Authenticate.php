<?php 

namespace App\Laravel\Middlewares\Portal;

use Closure,Auth;
use Illuminate\Contracts\Auth\Guard;

class Authenticate {

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $auth
	 * @return void
	 */
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next, $guard = null)
    {
        if ( !Auth::check() ) {
            
            $redirect_uri = $request->url();
            $redirect_key = base64_encode($redirect_uri);
            session()->put($redirect_key, $redirect_uri);
            session()->flash('notification-status', "error");
            session()->flash('notification-msg', "Restricted area. Users Access Only.");

            return redirect()->route('web.login', [$redirect_key]);
        }

        if (Auth::check() AND Auth::user()->active != 1){
    		Auth::logout();
    		session()->flash('notification-status', "error");
    		session()->flash('notification-msg', "Please Make sure your account is verified.");
    		return redirect()->route('web.login');
        }

        return $next($request);
    }

}
