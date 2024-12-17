<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreAuthenticationRequest;
use App\Http\Requests\UpdateAuthenticationRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(["message" => "success", "data" => User::all()], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function register(StoreAuthenticationRequest $request)
    {
        $request->validated();

        if (User::where('email', $request->email)->exists()) {
            return response()->json(["message" => "User already exists"], 409);
        }

        $user = User::create($request->all());

        if (!$user) {
            return response()->json(["message" => "Registration failed"], 400);
        }
        return response()->json(["message" => "success"], 201);
    }

    /**
     * Display the specified resource.
     */


    public function login(UpdateAuthenticationRequest $request)
    {
        $request->validated();
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(["message" => "User not found"], 404);
        }
        if (!Hash::check($request->password, $user->password)) {
            return response()->json(["message" => "Incorrect password"], 401);
        }

        $access_token = $user->createToken($user->email . 'auth_token' . time())->plainTextToken;

        return response()->json(["message" => "success", "data" => $user, "access_token" => $access_token], 200);
    }


    public function session(Request $request)
    {

        $user = $request->user();
        if (!$user) {
            return response()->json(["message" => "Session rejected"], 404);
        }

        $access_token = $request->bearerToken();
        return response()->json(["message" => "Session accepted", "data" => $user, "access_token" => $access_token], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(["message" => "user logged out"], 200);
    }
}
