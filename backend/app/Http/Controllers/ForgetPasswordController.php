<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\resetPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\forgetPasswordRequest;

class ForgetPasswordController extends Controller
{
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $user=User::where("email",$request->email)->first();
        $token=$user->createToken(name:'auth-token')->plainTextToken;
        $user->notify(new resetPassword($token));
        return response()->json([
            "message"=>"reset password has been sent"
        ]);
    }
    public function reset(forgetPasswordRequest $request){
        $validated=$request->validated();
        $user=User::where("email",$validated['email'])->first();
        $validated['password']=Hash::make($validated['password']);
        $user->update($validated);
        return response()->json([
            "data" => $user,
            "access_token" => $user->createToken(name:'auth-token')->plainTextToken,
            "token_type" => "bearer"
        ]);
    }
}