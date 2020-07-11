<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

use App\User;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function register(Request $request)
    {
      $this->validate($request, [
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'email' => 'required|email|unique:users',
        'password' => 'required'
      ]);

      $apikey = base64_encode(str_random(40));

      $user = User::create([
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'api_key' => $apikey,
      ]);

      return $user;

    }


    public function login(Request $request)

    {

        $this->validate($request, [
             'email' => 'required',
             'password' => 'required'
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if($user) {
          if(Hash::check($request->input('password'), $user->password)) {
            $apikey = base64_encode(str_random(40));
            User::where('email', $request->input('email'))->update(['api_key' => $apikey]);;
            return response()->json(['status' => 'success','api_key' => $apikey]);
          } else {
            return response()->json(['status' => 'Invalid Login Credentials'],422);

          }
        } else {
          return response()->json(['status' => 'No User Found'],404);
        }
        

    }

    public function users()
    {
        $users = User::latest()->paginate(1);
        
        return response()->json([
            'status' => '200-success',
            'data' => $users
        ]);
    }
}
