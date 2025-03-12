<?php

namespace Dash\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Authentication extends Controller
{

    public function index()
    {
        return view('dash::login');
    }

    public function loggedin(Request $request)
    {
        $data = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [], [
            'email'    => __('dash::dash.email'),
            'password' => __('dash::dash.password'),
        ]);

        $remember = !empty(request('remember_me')) ? true : false;
        $data['account_type'] = 'admin';

        if (auth()->guard('dash')->attempt($data, $remember)) {
            return redirect(app('dash')['DASHBOARD_PATH'] . '/dashboard');
        } else {
            session()->flash('error', __('dash::dash.failed_login_msg'));
            return back()->withInput();
        }
    }

    public function logout()
    {
        if (auth()->guard('dash')->logout()) {
            return redirect(app('dash')['DASHBOARD_PATH'] . '/login');
        } else {
            return redirect(app('dash')['DASHBOARD_PATH'] . '/dashboard');
        }
    }
}
