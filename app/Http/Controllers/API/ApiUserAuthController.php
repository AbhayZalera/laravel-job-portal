<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class ApiUserAuthController extends Controller
{
    function login(Request $request)
    {
        $user =  User::where('email', $request->email)->first();
        // dd($user);
        if (!$user || !Hash::check($request->password, $user->password)) {
            return ['message' => 'Invalid email or password', "Success" => false];
        }
        $success['token'] = $user->createToken('MyApp')->plainTextToken;
        $success['name'] = $user->name;
        return ['success' => true, "result" => $success, 'message' => 'User LogIn successfully'];
    }

    function singup(Request $request)
    {
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        $success['token'] = $user->createToken('MyApp')->plainTextToken;
        $success['name'] = $user->name;
        return ['success' => true, "result" => $success, 'message' => 'User register successfully'];
    }

    function logout(Request $request)
    {
        // dd($request->all());
        $request->user()->currentAccessToken()->delete();

        return ['success' => true, 'message' => 'User log out successfully'];
    }

    //password forgot
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $status = Password::broker('users')->sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? ['success' => true, 'message' => 'Password reset link sent successfully']
            : ['success' => false, 'message' => 'Error sending reset link'];
    }

    //reset Password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'token' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $status = Password::broker('users')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->update(['password' => bcrypt($password)]);
            }
        );
        // dd($status);

        return $status === Password::PASSWORD_RESET
            ? ['Success' => true, 'message' => 'Password reset successful']
            : ['Success' => false, 'message' => 'Invalid token or email'];
    }
}
