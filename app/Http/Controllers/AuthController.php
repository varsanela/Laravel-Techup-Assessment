<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Auth;

class AuthController extends Controller
{
    /**
     * Register a new user
     */
    public function register(Request $request)
    {   
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required', 
                'email' => 'required|email', 
                'password' => 'required|min:6'
            ]);
    
            if ($validator->fails()) {    
                return response()->json([
                    'error' => true,
                    'message' => "Some parameters are missing!"
                ], 400);
            }
    
            $user = User::create([
                'name' => $request->name, 
                'email' => $request->email, 
                'password' => bcrypt($request->password)
            ]);

            if($user) {
                return response()->json([
                    'success' => true,
                    'message' => 'Operation successful!',
                    'data' => $user
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Login
     */
    public function login(Request $request)
    {     
        try {   
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email', 
                'password' => 'required'
            ]);

            if ($validator->fails()) {    
                return response()->json([
                    'error' => true,
                    'message' => "Invalid credentials!"
                ], 400);
            }

            if( Auth::attempt(['email'=>$request->email, 'password'=>$request->password]) ) {
                $user = Auth::user();

                $token = $user->createToken($user->email . '-' . now());

                return response()->json([
                    'success' => true,
                    'message' => 'Logged In Successfully!',
                    'token' => $token->accessToken
                ]);
            }           

            return response()->json([
                'error' => true,
                'message' => 'Invalid credentials!',
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
    }
}
