<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;

class UserController extends Controller
{

	/**
     * The task repository instance.
     *
     * @var UserRepository
     */
    protected $users;


   /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $users)
    {
        $this->middleware('auth');

        $this->users = $users;
    }

    /**
	 * Display a list of all of the users.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function index(Request $request)
	{
		$users = $this->users->all();

        return view('users.index', [ 'users' => $users ]);
	}

	/**
	 * Create a new user.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function store(Request $request)
	{
	    $this->validate($request, [
	        'name' 			=> 'required|unique:users|max:255',
	       	'age' 			=> 'required|integer',
	        'email' 		=> 'required|unique:users|max:255',
	        'userType' 		=> 'required|max:255',
	    ]);

	    // Add User...
	     $user = new User;

	     $user->name 		= $request->name;
	     $user->age 		= $request->age;
	     $user->email 		= $request->email;
	     $user->userType	= $request->userType;
	     $user->password	= \Hash::make('abc123');
	     
	     $user->save();

	    return redirect('/users');
	}

	/**
	 * Destroy the given user.
	 *
	 * @param  Request  $request
	 * @param  User  $user
	 * @return Response
	 */
	public function destroy(Request $request, User $user)
	{

    	$user->where('id', $request->user)->delete();

    	return redirect('/users');
	}

	/**
     * Edit the given user     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, Request $request)
    {
        $current_user = $user->where('id', $request->user)->first();
        return view('users.edit')->with('user', $current_user);
    }

    /**
	 * Update user info.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function updateUser(Request $request, User $user)
	{
	    $this->validate($request, [
	        'name' 			=> 'required|max:255',
	       	'age' 			=> 'required|integer',
	        'email' 		=> 'required|max:255',
	        'userType' 		=> 'required|max:255',
	        ]);

	    // Update user...

        $user->where('id', $request->user)
        	 ->update([
        			'name' 		=> $request->name,
        			'age' 		=> $request->age,
        			'email' 	=> $request->email,
        			'userType' 	=> $request->userType,
        ]);

	    return redirect('/users');
	}

}
