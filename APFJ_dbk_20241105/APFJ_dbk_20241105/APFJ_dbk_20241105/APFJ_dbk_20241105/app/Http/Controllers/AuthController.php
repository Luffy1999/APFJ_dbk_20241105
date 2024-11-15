<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function register(Request $request) {
        $validateDate = $request->validate([
            'name'=>['required','string','max:255'],
            'email'=>['required','string','email','max:255','unique:users'],
            'password'=>['required','string','min:8','max:20'],
        ]);

        $user = User::create([
            'name'=> $validateDate['name'],
            'email'=> $validateDate['email'],
            'password'=> Hash::make( $validateDate['password']),
        ]);

        $token = $user->createtoken('auth_token')->plainTextToken;

        return response()->json( [
            "success"=> true,
            "error" =>[
                "code"=>0,
                "msg"=>""
            ],
            "data"=>[
                "access_token"=>$token,
                "token_type"=>"Bearer"
            ],
            "msg"=>"Usuario creado sattisfactoriamente",
            "count"=>1
        ]);
    }


    public function login(Request $request) {
        if(!Auth::attempt($request->only("email","password"))) {
            return response()->json([
                "success"=> false,
                "error"=>[
                    "code"=>401,
                    "msg"=> "No se reconocen las credenciales"
                ], 
                "data"=>"",
                "count"=> 0
            ],    401);
        }
        $user = User::where("email", $request->email)->firstOrFail();
        $token = $user->createToken("auth_token")->plainTextToken;

        return response()->json([
            "success"=> true,
            "error"=>[
                "code"=>200,
                "msg"=> ""
            ], 
            "data"=>[
                "acess_token"=>$token,
                "token_type"=> "Bearer"
                ],
            "msg"=>"Ha iniciado sesión correctamente",
            "count"=> 1
        ],    200);
    }

    public function me(Request $request) {
       return response()->json([
            "success"=> false,
                "error"=>[
                    "code"=>401,
                    "msg"=> "No se reconocen las credenciales"
                ], 
                "data"=>"",
                "count"=> 0
            ],    401);
    }
}