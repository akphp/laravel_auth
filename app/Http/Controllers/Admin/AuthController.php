<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
        $user = Admin::create($input); 
        $success['token'] =  $user->createToken('admin Acoount')->accessToken;
        return response()->json(['success'=>$success], 200); 
       }




       public function login_admin(Request $request)
       { 

        // login to user account admin (table == admin)
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
        // profile account admin 
        return response()->json(['data'=> $this->guard()->user() ], 200); 
    }


    public function guard()
    {    // guard defalut users  [admin , users , student , .......]

        // chang provider to admins 
        // Config::set('auth.guards.api.provider', 'admins');
        // return Auth::guard();
        
        return Auth::guard('admin');
    }


}
