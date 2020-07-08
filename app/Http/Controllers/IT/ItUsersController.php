<?php

namespace App\Http\Controllers\IT;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\SupportTeam;
use App\Models\CaseOptions;
use App\Models\Cases;
use App\Models\CasesView;
use App\Models\CasesBoard;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Hash;

class ItUsersController extends Controller
{
    public function itUser (Request $request) {

        $itUsers = SupportTeam::orderBy('s_firstName')->get();
        $user = Auth::user();
        if(!$user){
            abort(403);
        }

        return view('it.itUsers', compact('itUsers','user'));

    }

    public function itUserInsert (Request $request) {

        $name  = $request->input('s_firstName').' '.$request->input('s_lastName');
        $password =   Hash::make($request['password']);

        //dd($request['password']);

        $itUser = new SupportTeam();
        $itUser -> s_firstName = $request->input('s_firstName');
        $itUser -> s_lastName =$request->input('s_lastName');
        $itUser -> email =$request->input('email');

        $itUser->save();

        $supportteam_id = $itUser->id;


//user

        $programUser = new User();
        $programUser -> name = $name;
        $programUser -> supportteam_id = $supportteam_id;
        $programUser -> email =$request->input('email');
        $programUser -> password = $password;
        $programUser->save();

        return Response()->json(['success'=>true,]);

    }

    public function itUserEdit (Request $request) {

        $id =  $request->input('id');
        $name  = $request->input('s_firstName').' '.$request->input('s_lastName');
        $password =   Hash::make($request['password']);
        $findId=User::where('supportteam_id', '=',$id)
            ->select('id')
            ->pluck('id')
            ->first();
//dd($findId);
        $itUser = SupportTeam::find($id);
        $itUser -> s_firstName = $request->input('s_firstName');
        $itUser -> s_lastName =$request->input('s_lastName');
        $itUser -> email =$request->input('email');
        $itUser->save();

        //dd($name);

        $programUser = User::find($findId);
        $programUser -> email = $request->input('email');
        $programUser -> name = $name;
        $programUser -> password = $password;
        $programUser->save();


        return Response()->json(['success'=>true,]);

    }

    public function itUserDelete (Request $request) {

        $id =  $request->input('id');
        $findId=User::where('supportteam_id', '=',$id)
            ->select('id')
            ->pluck('id')
            ->first();
//dd($findId);
        SupportTeam::find($id)->delete();


        User::find($findId)->delete();

        return Response()->json(['success'=>true,]);

    }

}
