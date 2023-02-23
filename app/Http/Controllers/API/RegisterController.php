<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport; 

class RegisterController extends Controller
{

    /**
    * Function to resigster user/customer in the system and return token if successfully registerd.
    */
    public function registerUser(Request $request) {
        try {
            //Validated
            $validateUser = Validator::make($request->all(), 
            [
                'job_title' => 'required',
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required',
                'password' => 'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = User::create([
                'job_title' => $request->job_title,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
    * Function to check credentials and Login user/customer into the system and return token.
    */
    public function loginUser(Request $request) {
        try {
            $validateUser = Validator::make($request->all(), 
            [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if(!Auth::attempt($request->only(['email', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
    * Function to log out user/customer from the system.
    */
    public function logoutUser(Request $request) {
        $request->user()->currentAccessToken()->delete(); 
        return response()->json([
                    'status' => true,
                    'message' => 'Users Logged Out Successfully', 
                ], 200);
    }



    /**
    * Function to import user from csv
    */
    public function importUsers(Request $request) {

        $user_data = public_path().'/import-data/customers.csv'; 
 

        Excel::import(new UsersImport, $user_data);  

        return response()->json([   
            'message' => 'User Imported Successfully',
        ], 200);
    }

}
