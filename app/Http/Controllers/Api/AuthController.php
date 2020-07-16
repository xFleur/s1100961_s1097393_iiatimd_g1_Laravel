<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//need voor auth
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User; 
use Tymon\JWTAuth\Facades\JWTAuth;



class AuthController extends Controller
{
    
   //methode toevoegen voor login
   public function login(Request $request) {

        $creds = $request->only(['email','password']);
        
        // try to auth and get the token using api authentication
        if (!$token=auth()->attempt($creds)) {
            // if the credentials are wrong we send an unauthorized error in json format
            return response()->json([
                'success' => false,
                'message' => 'invalid credentials'
            ]);
        }

        return response()->json([
            'success' => true ,
            'token' => $token, 
            'user' => Auth::user()
        ]);
    }

   //methode toevoegen voor registreren
   public function register(Request $request) {

        $encryptedPass = Hash::make($request->password);

        $user = new User;

        //encrypt pwd before in database
        try {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $encryptedPass;
            $user-> save();
            return $this->login($request);

        }
        catch(Exception $e) {
            return response()->json([
                'success' => false,
                'message' => ''.$e
            ]);
        }

    }
    //methode toevoegen voor uitloggen
   public function logout(Request $request) {
    try {
        JWTAuth::invalidate(JWTAuth::parseToken($request->token));
        return response()->json([
            'success' => true,
            'message' => 'logout success'
        ]);

    }
    catch(Exception $e) {
        return response()->json([
            'success' => false,
            'message' => ''.$e
        ]);
    }

}

    //this function saves user name, lastname and photo 
    public function saveUserInfo(Request $request){
        $user = user::find(Auth::user()->id);
        $user->name = $request->name;
        //$user->email = $request->email;

        //$user->lastname = $request->lastname;
        $photo = '';


        //this function saves user name, lastname and photo 
        //if($request->photo!= ''){
            //user time fot photo name to prevent name dublication
            //$photo = time().'.jpg';
            //decode photo string and save to storage/profiles
            //file_put_contents('storage/profiles/'.$photo,base64_decode($request->photo));
            //$user->photo = $photo;
        //}

        $user->update();

        return response()->json([
            'success' => true,
            'photo' => $photo
        ]);



    }

    public function userinfo() {    
        try {
        JWTAuth::invalidate(JWTAuth::parseToken($request->token));
        $user = user::find(Auth::user()->id);
        $user->name = $request->name;
        $user->update();

        return response()->json([
            'success' => true,
            'message' => 'get user info success'
        ]);

    }
    catch(Exception $e) {
        return response()->json([
            'success' => false,
            'message' => ''.$e
        ]);
    }
    }
}