<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\servant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ServantController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:servants',
            'psw' => 'required',

        ]);

        $user = Servant::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->psw),

        ]);
        $token = $user->createToken($request->email)->accessToken;
        return response([
            'token' => $token,
            'message' => 'Registration Success',
            'status' => 'success'
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $user = Servant::where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken($request->email)->accessToken;
            return response([
                'token' => $token,
                'message' => 'Login Success',
                'status' => 'success'
            ], 200);
        }
        return response([
            'message' => 'The Provided Credentials are incorrect',
            'status' => 'failed'
        ], 401);
    }


    public function logout()
    {
        if (Auth::guard('servants')->check()) {
            $accessToken = Auth::guard('servants')->user()->token();

            DB::table('oauth_refresh_tokens')
                ->where('access_token_id', $accessToken->id)
                ->update(['revoked' => true]);
            $accessToken->revoke();

            return Response(['data' => 'Unauthorized', 'message' => 'User logout successfully.'], 200);
        }
        return Response(['data' => 'Unauthorized'], 401);
    }

    public function getUserDetail()
    {
        if (Auth::guard('servants')->check()) {
            $user = Auth::guard('servants')->user();
            return response(['data' => $user], 200);
        }
        return response(['data' => 'Unauthorized'], 401);
    }


    public function change_password(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);
        $loggeduser = auth()->user();
        // dd($loggeduser);
        $loggeduser->password = Hash::make($request->password);
        $loggeduser->save();
        return response([
            'message' => 'Password Changed Successfully',
            'status' => 'success'
        ], 200);
    }
}
