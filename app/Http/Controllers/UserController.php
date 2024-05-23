<?php

namespace App\Http\Controllers;

use Exception;
use App\Mail\OTPMail;
use App\Helper\JWTtoken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User; // Change the namespace to the correct one

class UserController extends Controller // Capitalize the 'C' in 'Controller'
{
    public function registration(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:3',
            ]);

            $name = $request->name;
            $email = $request->email;
            $password = $request->password;

            User::create([
                'name' => $name,
                'email' => $email,
                'password' => $password,
            ]);

            return redirect()->route('login');
        } catch (Exception $error) {
            return $error->getMessage();
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|min:3'
            ]);
            $email = $request->email;
            $password = $request->password;
            $user = User::where('email', $email)->where('password', $password)->first();
            if ($user) {
                $token = JWTtoken::createToken($user->email, $user->id);
                return response()->json([
                    'msg' => 'Login successs',
                ])->cookie('token', $token, 60 * 24 * 30);
            } else {
                return 'email or pass rong';
            }
        } catch (Exception $logerror) {
            return $logerror->getMessage();
        }
    }

    public function sendOtp(Request $request)
    {
        try {
            $email = $request->email;
            $otp = rand(1000, 9999);
            $user = User::where('email', $email)->first();
            if ($user) {
                Mail::to($email)->send(new OTPMail($otp));
                User::where('email', $email)->update(['otp' => $otp]);
                return redirect()->route('verify-otp');
                // return response()->json([
                //     'status' => 'succcess',
                //     'massage' => 'OTP has been send'
                // ]);
            }
        } catch (Exception $see) {
            return response()->json([
                'status' => 'error',
                'massage' => $see->getMessage()
            ]);
        }
    }

    public function verifyOtp(Request $request)
    {
        try {
            $email = $request->email;
            $otp = $request->otp;

            $user = User::where('email', $email)->where('otp', $otp)->first();
            if ($user) {
                User::where('email', $email)->where('otp', $otp)->update(['otp' => '0']);
                $token = JWTToken::createToken($user->email, $user->id);

                return response()->json([
                    'status' => 'success',
                    'msg' => 'OTP has been verifyed '
                ])->cookie('token', $token, 30 * 40 * 20);
            }
        } catch (Exception $se) {
            return response()->json([
                'status' => 'error',
                'msg' => $se->getMessage()
            ]);
        }
    }

    public function resetPassword(Request $request)
    {
        try {
            $email = $request->header('email');
            $password = $request->password;
            User::where('email', $email)->update(['password' => $password]);
            return response()->json([
                'status' => 'success',
                'massage' => 'Password change successfully',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'massage' => $e->getMessage()
            ]);
        }
    }
}
