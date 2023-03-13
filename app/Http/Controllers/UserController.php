<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('User.profile',[
            'title' => "Profile"
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware('auth');
    }

    public function changepwd(Request $request){
         if (!(Hash::check($request->get('currentPassword'), Auth::user()->password))) {
        // The passwords matches

        return redirect()->back()->withInput(['tab'=>'profile-change-password'])->with("error","Your current password does not matches with the password you provided. Please try again.");
        }

        if(strcmp($request->get('currentPassword'), $request->get('newPassword')) == 0){
        //Current password and new password are same
        return redirect()->back()->withInput(['tab'=>'profile-change-password'])->with("error","New Password cannot be same as your current password. Please choose a different password.");
     }
         $validatedData = $request->validate([
        'currentPassword' => 'required',
        'newPassword' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();
        $user->password = bcrypt($request->get('newPassword'));
        $user->save();

    return redirect()->back()->withInput(['tab'=>'profile-change-password'])->with("success","Password changed successfully !");


    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
