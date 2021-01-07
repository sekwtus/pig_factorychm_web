<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    protected function credentials(Request $request)
    {
        // $field = $this->field($request);
        return [
            'name' => $request->get('username'),
            'password' => $request->get('password'),
        ];
    }

    public function field(Request $request)
    {
        // $email = $this->username();
        // return filter_var($request->get($email), FILTER_VALIDATE_EMAIL) ? $email : 'username';
    }

    protected function validateLogin(Request $request)
    {
         //$field = $this->field($request);
        $messages = ["username.required" => 'username ว่าง',"password.required" => 'password ว่าง'];
        $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|string',
        ], $messages);
    }
}
