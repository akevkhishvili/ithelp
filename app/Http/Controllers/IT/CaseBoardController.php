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
use App\Models\CaseCount;

class CaseBoardController extends Controller
{
    public function caseboard(){

        $cases = CasesView::orderBy('id','desc')->paginate(20);
        //dd($oldValue);
        return view('it.caseboard', compact('cases'));

    }
    public function finishCase(Request $request){

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

    public function acceptCase(Request $request){
        $user = Auth::user();
        //dd($user->name);

        $id = $request->input('id');
        $acceptCase = Cases::find($id);
        $acceptCase->status =  $request->input('status');
        $acceptCase->accepted_by =  $user->name;
        $acceptCase->save();

        $casecountID = 1;
        $casecount = CaseCount::find($casecountID);
        $casecount->action =  1;
        $casecount->save();
        return Response()->json(['success'=>true,]);
    }
    public function forwardCase(Request $request){

        $id = $request->input('recordID');
        $forwardCase = Cases::find($id);
        $forwardCase->stacked_to =  $request->input('id');
        $forwardCase->status =  "მიმაგრებულია";
        $forwardCase->accepted_by =  "";
        $forwardCase->save();

        $casecountID = 1;
        $casecount = CaseCount::find($casecountID);
        $casecount->action =  1;
        $casecount->save();
        return Response()->json(['success'=>true,]);
    }

    public function caseNotification() {
        $oldValue = CaseCount::select('oldValue')->pluck('oldValue')->first();
        $count = CasesView::count();
        $action = CaseCount::where('id', '=', 1)->select('action')->pluck('action')->first();

        return Response()->json(['success'=>true, $oldValue, $count, $action]);
        //dd($oldValue);
    }

    public function caseNotificationRecord(request $request) {
        $cases = CasesView::where('status','=',"აქტიური")
            ->orWhere('status','=',"მიმაგრებულია")
            ->orderBy('id','desc')->paginate(20);

        $id = 1;
        $changeValue = CaseCount::find($id); //იპოვოს id და დაიწყოს ჩაწერა

        $changeValue->oldValue = $request->input('newValue');
        $changeValue->action = $request->input('action');

        $changeValue->save();

        $html = view('it/caseBoardTable')->with(compact('cases'))->render();
        return response()->json(['success' => true, 'html' => $html]);
    }

    public function postItResponse(request $request) {

        $caseId = $request->input('caseId');
        $text = $request->input('value');

        //dd($text);
        cases::where('id','=', $caseId)->update(['itResponse' => $text, 'itResponseRead' => 2,'itResponsePerson' => Auth::user()->name]);

        return response()->json(['success' => true]);
    }

    public function getItResponse(request $request) {

        $caseId = $request->input('caseId');
        $itResponse = cases::where('id','=', $caseId)->select('itResponse')->pluck('itResponse')->first();

        return response()->json(['success' => true, $itResponse]);
    }
    public function getItResponseForUser(request $request) {
        $caseId = $request->input('caseId');
        $userId = $request->input('userId');
        if(!empty($caseId)){
            $casesReponses = CasesView::where('requestUser', '=', $userId)->where('Id','=', $caseId)->get();
            cases::where('id','=', $caseId)->update(['itResponseRead' => 1]);
        }else{
            $casesReponses = CasesView::where('requestUser', '=', $userId)->get();
        }

        return response()->json([$casesReponses]);
    }
}
