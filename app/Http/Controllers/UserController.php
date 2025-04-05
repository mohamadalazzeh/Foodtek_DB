<?php

namespace App\Http\Controllers;
use Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class UserController extends Controller
{
    public function register(Request $request){
$request->validate([
    'name'=>'required|string|max:255',
    'email'=>'required|string|email|max:255|unique:users,email',
    'phone'=>'required|string|max:255',
    'birth'=>'required|string|max:255',
    'password'=>'required|string|min:8|confirmed'
]);
$user=user::create([
    'name'=>$request->name,
    'email'=>$request->email,
    'phone'=>$request->phone,
    'birth'=>$request->birth,
    'password'=>Hash::make($request->password)
]);   
 return response()->json([
    'message'=>'user registered successfully',
    'User'=>$user
    ,201]);
}
    //
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            return response()->json(['message' => 'Login successful']);
        }
    
        return response()->json(['error' => 'Invalid credentials'], 401);
    }
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users']);
    
        $token = Password::getRepository()->createNewToken();
        
        Mail::raw("Your reset code is: $token", function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Password Reset Code');
        });
    
        return response()->json(['message' => 'Reset code sent to email']);
    }
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'token' => 'required',
            'password' => 'required|min:6',
        ]);
    
        $user = User::where('email', $request->email)->first();
    
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
    
        $user->password = Hash::make($request->password);
        $user->save();
    
        return response()->json(['message' => 'Password reset successfully']);
    }

}
