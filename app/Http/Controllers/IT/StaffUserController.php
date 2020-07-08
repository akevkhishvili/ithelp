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

class StaffUserController extends Controller
{
    public function staffUser (Request $request) {
        $user = Auth::user();
        if(!$user){
            abort(403);
        }
        $staffUsers = Staff::orderBy('firstName')->get();

        return view('it.staffUsers', compact('staffUsers','user'));

    }

    public function staffUserCreate (Request $request){

        $newMember = new Staff();
        $newMember -> firstName = $request->input('firstName');
        $newMember -> lastName = $request->input('lastName');
        $newMember -> email = $request->input('email');
        $newMember -> phone = $request->input('phone');
        $newMember -> mobile = $request->input('mobile');
        $newMember -> room = $request->input('room');
        $newMember -> ipAddress = $request->input('ip');

        $newMember->save();

        return Response()->json(['success'=>true]);
    }

    public function staffUserEdit (Request $request) {

        $id = $request->input('id');
        $name = $request->input('name');
        $value = $request->input('value');

        if($name == 'firstName') {
            $find_id = Staff::where('id', '=', $id)
                ->select('id')
                ->pluck('id')
                ->first();
            //dd($find_id);

            $editStaffUser = Staff::find($find_id); //იპოვოს id და დაიწყოს ჩაწერა

            $editStaffUser->firstName = $value;

            $editStaffUser->save();



        }elseif($name == 'lastName') {
            $find_id = Staff::where('id', '=', $id)
                ->select('id')
                ->pluck('id')
                ->first();
            //dd($find_id);

            $editStaffUser = Staff::find($find_id); //იპოვოს id და დაიწყოს ჩაწერა

            $editStaffUser->lastName = $value;

            $editStaffUser->save();



        }elseif($name == 'email') {
            $find_id = Staff::where('id', '=', $id)
                ->select('id')
                ->pluck('id')
                ->first();
            //dd($find_id);

            $editStaffUser = Staff::find($find_id); //იპოვოს id და დაიწყოს ჩაწერა

            $editStaffUser->email = $value;

            $editStaffUser->save();



        }elseif($name == 'phone') {
            $find_id = Staff::where('id', '=', $id)
                ->select('id')
                ->pluck('id')
                ->first();
            //dd($find_id);

            $editStaffUser = Staff::find($find_id); //იპოვოს id და დაიწყოს ჩაწერა

            $editStaffUser->phone = $value;

            $editStaffUser->save();



        }elseif($name == 'room') {
            $find_id = Staff::where('id', '=', $id)
                ->select('id')
                ->pluck('id')
                ->first();
            //dd($find_id);

            $editStaffUser = Staff::find($find_id); //იპოვოს id და დაიწყოს ჩაწერა

            $editStaffUser->room = $value;

            $editStaffUser->save();



        }elseif($name == 'ipAddress') {
            $find_id = Staff::where('id', '=', $id)
                ->select('id')
                ->pluck('id')
                ->first();
            //dd($find_id);

            $editStaffUser = Staff::find($find_id); //იპოვოს id და დაიწყოს ჩაწერა

            $editStaffUser->ipAddress = $value;

            $editStaffUser->save();



        }

        return Response()->json(['success'=>true, $id, $name]);


    }

    public function staffdelete(request $request){
        $id = $request->input('id');

        $delRecord = Staff::find($id);
        $delRecord->delete();

        return response()->json(['success' => true]);

    }

}
