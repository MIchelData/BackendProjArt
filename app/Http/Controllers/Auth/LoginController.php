<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
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
    //protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {


       /*  $this->middleware('guest')->except('logout');
        $this->middleware('guest:eleve')->except('logout');
        $this->middleware('guest:enseignant')->except('logout'); */
        if (auth()->guard('eleve')->check()) {
            $this->middleware('guest:eleve')->except('logout');
        } elseif (auth()->guard('enseignant')->check()) {
            $this->middleware('guest:enseignant')->except('logout');
        }
    }
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        if (auth()->guard('eleve')->attempt(['email' => $request->email, 'password' => $request->password])) {
            //dd('eleve');
            return redirect()->intended('app');
        } elseif (auth()->guard('enseignant')->attempt(['email' => $request->email, 'password' => $request->password])) {
            //dd('prof');
            return redirect()->intended('app');
        } else {
            return back()->withErrors(['email' => 'Email or Password is incorrect.']);
        }
    }

    /* public function login(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);
        if (Auth::guard('enseignant')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
            return $this->redirectTo = RouteServiceProvider::HOME;
        }
        return back()->withInput($request->only('email', 'remember'));
    }

    public function eleveLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('eleve')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {

            return $this->redirectTo = RouteServiceProvider::HOME;
        }
        return back()->withInput($request->only('email', 'remember'));
    } */
}



/* public function login(Request $request)
{
    $this->validate($request, [
        'email'   => 'required|email',
        'password' => 'required|min:6'
    ]);
    if (Auth::guard('enseignant')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
        return $this->redirectTo = RouteServiceProvider::HOME;
    }// blogg
    return back()->withInput($request->only('email', 'remember'));
} */
/* public function showBloggerLoginForm()
{
    return view('auth.login', ['url' => 'blog']);
} */
