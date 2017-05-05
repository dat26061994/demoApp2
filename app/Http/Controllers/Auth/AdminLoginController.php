<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class AdminLoginController extends Controller
{
    public function __contruct()
    {
        $this->middleware('guest:admin');
    }

    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        // Validate Form 
        $this->validate($request, [
            'username' => 'required|max:100',
            'password' => 'required|max:100'
        ]);
        // Attempt to log the user in
        if (Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password],
            $request->remember)
        ) {
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->back()->withInput($request->only('username', 'remember'));

    }
}
