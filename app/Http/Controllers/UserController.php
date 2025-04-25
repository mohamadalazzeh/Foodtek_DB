<?php

namespace App\Http\Controllers;
use Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use App\Mail\SendOtpMail;
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
        $user = User::where('email', $request->email)->first();

    if (!$user) {
        return response()->json(['message' => 'البريد الإلكتروني غير موجود'], 404);
    }
    // توليد رمز تحقق عشوائي
    $otp = rand(100000, 999999);
    // تخزينه في قاعدة البيانات (مثلاً في عمود otp)
    $user->otp = $otp;
    $user->save();
    // إرسال الرمز إلى الإيميل
    Mail::raw("رمز التحقق الخاص بك هو: $otp", function ($message) use ($user) {
        $message->to($user->email)
                ->subject('رمز التحقق لإعادة تعيين كلمة المرور');
    });

    return response()->json(['message' => 'تم إرسال رمز التحقق إلى البريد الإلكتروني']);
}
public function verifyOtp(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'otp' => 'required'
    ]);

    $user = User::where('email', $request->email)
                ->where('otp', $request->otp)
                ->first();

    if (!$user) {
        return response()->json(['message' => 'رمز التحقق غير صحيح'], 400);
    }

    return response()->json(['message' => 'تم التحقق من الرمز بنجاح']);
}

    public function resetPassword(Request $request)
    { $request->validate([
        'email' => 'required|email',
        'otp' => 'required',
        'new_password' => 'required|min:6'
    ]);

    $user = User::where('email', $request->email)
                ->where('otp', $request->otp)
                ->first();

    if (!$user) {
        return response()->json(['message' => 'البيانات غير صحيحة'], 400);
    }

    $user->password = Hash::make($request->new_password);
    $user->otp = null; // حذف الرمز بعد الاستخدام
    $user->save();

    return response()->json(['message' => 'تمت إعادة تعيين كلمة المرور بنجاح']);;
    }

}
