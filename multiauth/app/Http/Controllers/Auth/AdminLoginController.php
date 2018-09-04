<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class AdminLoginController extends Controller
{

    public function __construct() 
    {
        // to use the functions here is need to be a admin guest, but to logout the middleware 
        // need to allows to access the logout when logged in as a admin
        // use the except for that
        $this->middleware('guest:admin', ['except' => ['logout']]);
    }

    public function showLoginForm() 
    {
        return view('auth.admin-login'); 
    }

    public function login(Request $request) 
    {
        // validate the form data
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        // attempt to log user in
        if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember))
        {
            // if successful, then redirect to their intened location
            return redirect()->intended(route('admin.dashboard')); // can use when redirect... track the user back where they were when then login pops up
        }

        // if unsuccessful, ten redirect back to the login with the form data
        return redirect()->back()->withInput($request->only('email', 'remember')); // send back to login page
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/');
    }
}
