<?php

namespace App\Http\Controllers\IT;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\SupportTeam;
use App\Models\CaseOptions;
use App\Models\Cases;
use App\User;
use App\Models\CasesView;
use App\Mail\NewCase;
use Illuminate\Support\Facades\Mail;
use App\Models\CaseCount;
use App\Models\Message;
use App\Models\Chat;
use Carbon\Carbon;

class CasePageController extends Controller
{
    public function casePage(){

        $ip = \Request::getClientIp(true);

        //dd($ip);
        $user=Staff::where('ipAddress','=', $ip)->first();
        if(!$user){
            abort(403);
        }
        $supportTeam = SupportTeam::orderBy('id')->get();
        $caseOptions = CaseOptions::get();
        $cases = CasesView::where('ipAddress','=', $ip)->orderBy('id','desc')->paginate(5);

        $users = User::where('status','=',"Active")->get();

//dd($cases);
        return view('it.casePage', compact('user','supportTeam','caseOptions','cases', 'users'));

    }

    public function newcase(Request $request){
        //dd($request->input('to'));


        //$itHead = "gdatukishvili@cu.edu.ge";
        $ip = \Request::getClientIp(true);
        $reciveEmail = $request->input('reciveEmail');
        $user=Staff::where('ipAddress','=', $ip)->first();
        $Case = $request->input('newcase');
        $otherCase = $request->input('otherCase');
        $supportteam_id = $request->input('to');
        $subject = $request->input('to');
        $room = $user->room;
        $phone = $user->phone;
        $fromFirstName = $user->firstName;
        $fromLastName = $user->lastName;
        $caseText = $request->input('caseText');
        //dd($caseText);
        $tomail = SupportTeam::where('id','=',$supportteam_id)->select('email')
            ->pluck('email')
            ->first();
        if($Case=='z'){
            $insetCase = $otherCase;
        }else{
            $insetCase = $Case;
        }


        $newCase = new Cases();
        $newCase -> supportteam_id = $supportteam_id;
        $newCase ->caseText = $request->input('caseText');
        $newCase ->tomail = $tomail;
        $newCase ->subject = $insetCase;
        $newCase ->requestUser =$user->id;
        $newCase ->room = $room;
        $newCase ->phone = $phone;
        $newCase ->status = "აქტიური";
        $newCase ->ipAddress = $ip;

        $newCase->save();

       /* $casecountID = 1;
        $casecount = CaseCount::find($casecountID);
        $casecount->action =  1;
        $casecount->save();*/

        //გაიგზავნოს მეილი
        $date = Carbon::now()->toDateTimeString();
        $requestUserMail = Staff::where('id','=',$user->id)->select('email')->pluck('email')->first();
        $mailSubject = $insetCase;
        $subject  = "NewCase".$date;

        $request->session()->flash('subject', $subject);
        Mail::to($requestUserMail)->send(new newCase($fromLastName,$mailSubject,$fromFirstName,$room,$phone,$caseText));



        // $request->session()->flash('subject', $mailSubject);

        //Mail::to($tomail)->cc($itHead)->send(new NewCase($fromLastName,$mailSubject,$fromFirstName,$room,$phone,$caseText));



        return Response()->json(['success'=>true,]);

    }
    public function closecase(Request $request){

        $id = $request->input('id');
        $closeCase = Cases::find($id);
        $closeCase->status =  $request->input('status');
        $closeCase->save();

        $casecountID = 1;
        $casecount = CaseCount::find($casecountID);
        $casecount->action =  1;
        $casecount->save();

        return Response()->json(['success'=>true,]);
    }
}
