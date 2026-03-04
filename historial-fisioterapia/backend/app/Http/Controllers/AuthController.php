<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    public function login(Request $request){
        $credentials = $request->only('email','password');
        if(!$token = JWTAuth::attempt($credentials)){
            return response()->json(['error'=>'Credenciales inválidas'],401);
        }
        return response()->json(['token'=>$token,'user'=>new UserResource(auth()->user())]);
    }
    public function me(){
        return new UserResource(auth()->user());
    }
}
