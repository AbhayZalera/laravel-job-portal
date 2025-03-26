<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Password;

class ApiAdminAuthController extends Controller
{
    function login(Request $request)
    {
        $admin =  Admin::where('email', $request->email)->first();
        // dd($user);
        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return ['message' => 'Invalid email or password', "Success" => false];
        }
        $success['token'] = $admin->createToken('Shwet')->plainTextToken;
        $success['name'] = $admin->name;
        return ['success' => true, "result" => $success, 'message' => 'Admin login successfully'];
    }

    function singup(Request $request)
    {
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        $admin = Admin::create($data);
        $success['token'] = $admin->createToken('Shwet')->plainTextToken;
        $success['name'] = $admin->name;
        return ['success' => true, "result" => $success, 'message' => 'Admin Register successfully'];
    }

    function logout(Request $request)
    {
        // dd($request->all());
        $request->user()->currentAccessToken()->delete();

        return ['success' => true, 'message' => 'Admin log out successfully'];
    }

    //password forgot
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins,email',
        ]);

        $status = Password::broker('admins')->sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? ['success' => true, 'message' => 'Password reset link sent successfully']
            : ['success' => false, 'message' => 'Error sending reset link'];
    }

    //reset Password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins,email',
            'token' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $status = Password::broker('admins')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($admin, $password) {
                $admin->update(['password' => bcrypt($password)]);
            }
        );
        // dd($status);

        return $status === Password::PASSWORD_RESET
            ? ['Success' => true, 'message' => 'Password reset successful']
            : ['Success' => false, 'message' => 'Invalid token or email'];
    }
}
