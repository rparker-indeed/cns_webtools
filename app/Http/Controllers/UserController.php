<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $currentUser;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $currentUser = User::findOrFail(Auth::id());
        if($currentUser->groups->contains(1)) {
            $users = User::orderBy('name')->paginate(25);
            return view('users.listUsers', compact('users'));
        }
        else{
            $request->session()->flash('error', 'You are not authorized to view the User List');
           return redirect('/');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $currentUser = User::findOrFail(Auth::id());
        if($currentUser->groups->contains(1)) {
            return view('auth.register');
        }
        else{
            $request->session()->flash('error', 'You are not authorized to create users');
            return redirect('/');
        }
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
    public function show(User $user)
    {

        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, Request $request)
    {
        //
        $currentUser = User::findOrFail(Auth::id());
        if($currentUser->id == $user->id || $currentUser->groups->contains(1)){ //userid= 1 is super user
            return view('auth.register', compact('user'));
        }
        else{
            $request->session()->flash('error', 'You are not authorized to edit profile: ' . $user->name);
            return redirect('/');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        $validRules = [
            'name' => 'required|max:255',
        ];
        if($request->input('email') != $user->email ) {
            $validRules['email'] ='required|email|max:255|unique:users';
        }

        if($request->input('password') != null || $request->input('old_password') != null){
            $validRules['password'] = 'min:6|confirmed';
        }
       $this->validate($request, $validRules);

       if(array_key_exists('password', $validRules)){
           if(Hash::make($request->input('old_password')) == $user->password ){
               $user->password = Hash::make($request->input('password'));
           }
           else{
               $request->session()->flash('error', 'Bad Old Password ' . $user->name);
            }
       }

            //$user = $this->request_to_DB_fields($user, $request);
           // $user->save();
           $request->session()->flash('status', 'Successfully updated user: ' . $user->name);
         return redirect(route('users.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Request $request)
    {

        $currentUser = User::findOrFail(Auth::id());
        if($currentUser->groups->contains(1)) { //userid= 1 is super user
            //delete user
            $user->delete();
        }
        else{
            $request->session()->flash('error', 'You are not authorized to delete users');
            return redirect('/');
        }
        //
    }


   private function request_through_validator(Request $request){


    }

}
