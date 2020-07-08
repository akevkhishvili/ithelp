<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CasesView;
use App\Models\Staff;
use App\Models\SupportTeam;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $user = Auth::user();
        //$user_ip = Auth::user();
        //$id = $user_ip->supportteam_id;
        //dd($user->supportteam_id);
        $cases = CasesView::orderBy('id','desc')
            ->paginate(20);
        $supportTeam = SupportTeam::get();
        $staffUsers = Staff::get();
        return view('home', compact('cases','user','supportTeam', 'staffUsers'));
    }

    public function logout(Request $request) {
        Auth::logout();
        return redirect('/login');
    }

}
