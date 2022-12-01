<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Http\Controllers\BaseController as BaseController;
use \Illuminate\Support\facades\Auth;
use Validator;
use App\Models\User;

class AuthController extends BaseController {


    public function signIn(Request $request) {

        if( Auth::attemp(["email" => $request->email, "password" => $request->password])) {

            $authUser = Auth::user();
            $succes["token"] = $authUser->createToken("MyAuthApp")->plainTextToken;
            $success["name"] = $authUser->name;

            return $this->sendResponse($success, "Sikeres bejelentkezés!");
        }else {
            return $this->sendError("Unathorized.".["error" => "Hibás adatok"]);
        }
    }

    public function signUp(Request $request) {
        
        $validator = Validator::make($request->all(), [

            "name" => "required",
            "email" => "required",
            "password" => "required",
            "confirm_password" => "required|same:password"
        ]);

        if( $validator->fails()) {

            return sendError("Error validation", $validator->errors());
        }

        $input = $request->all();
        $input["password"] = bcrypt($input["password"]);
        $user = User::create($input);
        $success["name"] = $user->name;

        return $this->sendResponse($success, "Sikeres regisztráció!");
    }
}
