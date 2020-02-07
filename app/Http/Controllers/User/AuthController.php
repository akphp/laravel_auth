<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Client;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use DB;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public $client ;
    public function __construct()
    {
        $this->client = DB::table('oauth_clients')->where('id', 2)->first();
    }




    public function register(Request $request) {    
        $validator = Validator::make($request->all(), 
                     [ 
                     'name' => 'required',
                     'username' => 'required',
                     'email' => 'required|email',
                     'password' => 'required',  
                     'c_password' => 'required|same:password', 
                    ]);   
        if ($validator->fails()) {          
              return response()->json(['error'=>$validator->errors()], 401);                        }    
        $input = $request->all();  
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input); 
        $success['token'] =  $user->createToken('Users Acoount')->accessToken;
        return response()->json(['success'=>$success], 200); 
       }



       public function login_user(Request $request)
       { 
           // login to user account user (table == users)
        $credentials = $request->only('username', 'password');
        if($this->guard()->attempt($credentials)){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')->accessToken; 
            return response()->json(['success' => $success], 200); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }

    public function profile()
    {
        // profile user account 
        return response()->json(['data'=> $this->guard()->user() ], 200); 
    }



    public function guard()
    {    // guard defalut users  [admin , users , student , .......]
        return Auth::guard();
    }


    
}
