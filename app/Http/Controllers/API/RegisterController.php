<?php

   

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\DB;use Illuminate\Http\Request;

use App\Http\Controllers\API\BaseController as BaseController;

use App\Models\User;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Validator;


class RegisterController extends BaseController

{

    /**

     * Register api

     *

     * @return \Illuminate\Http\Response

     */
    public function showAll()  {
        $user = Auth::guard('api')->user()->id;      
        return response()->json(['data' => $user], 200, [], JSON_NUMERIC_CHECK);
}
    public function index()
    {
        $users = User::all();
        return response()->json([
            'status'=> 200,
            'users'=>$users,
        ]);
    }





    public function register(Request $request)

    {

        $validator = Validator::make($request->all(), [

            'name' => 'required',

            'email' => 'required|email',

            'password' => 'required',

            'c_password' => 'required|same:password',

            'role'=>'required',

            'image' ,

        ]);

 
        $path =$request ->file('image')->storeAs('storage/image','oussama');


                if($validator->fails()){

            return $this->sendError('Validation Error.', $validator->errors());       

        }

   

        $input = $request->all();
        $input['image'] = $path;
        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);

        $success['token'] =  $user->createToken('tokenruser')->accessToken;

        $success['name'] =  $user->name;
        





        return $this->sendResponse($success, 'User register successfully.');

    }

   

    /**

     * Login api

     *

     * @return \Illuminate\Http\Response

     */



 /**   public function login(Request $request)

    *{

     *   if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 

      *      $user = Auth::user(); 
       *     $success['token'] =  $user->createToken('tokenruser')->accessToken;


        *    $success['name'] =  $user->name;

   

         *   return $this->sendResponse($success, 'User login successfully.');

       * } 

        *else{ 

         *   return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);

       * } 

    * }*/
    public function edit ($id){
        $user = User::find($id);
        return response()->json([
            'status'=> 200,
            'user'=>$user,
        ]);


    }
    public function update ( Request $request,$id){


        $user =  User::find( $id);
        $user -> name = $request->input('name');
      
        $user -> email = $request->input('email');
        $user -> role = $request->input('role');
         $user->update();
          
         return response()->json([
             'status'=>200,
             'message'=>'update add',

         ]);}







    public function destroy(Request  $request, $id){
        $users =  User::find( $id);
        $users->delete();
        $success['name'] =  $request->user;

        return $this->sendResponse($success, 'User deleted .');;

     }

     public function destroyAllusers(Request  $request){
        DB::table('users')->delete();
        
        return response()->json([
            'status'=>200,
            'message'=>'update add',

        ]);

     }

     public function logout(Request $request)
     {
        // $user = Auth::guard("api")->user()->token();
        // $user->revoke();
        // $responseMessage = "successfully logged out";
        //         return response()->json([
        //         'success' => true,
        //         'message' => $responseMessage
        //         ], 200);
        if ($request->user()) { 
            $request->user()->tokens()->delete();
        }
        return response()->json(['message' => 'You are Logout'], 200);
     }
  
    public function getuser(Request $request) {
        $user= auth('api')->user()->name;
        return response()->json([
            'status'=> 200,
            'name'=>$user,
        ]);
			
    }
    public function getuserpic(Request $request) {
        $user= auth('api')->user()->image;
        return response()->json([
            'status'=> 200,
            'user'=>$user,
        ]);
			
        
    }
    public function getuserrole(Request $request) {
        $user= auth('api')->user()->role;
        return response()->json([
            'status'=> 200,
            'user'=>$user,
        ]);
    }
}