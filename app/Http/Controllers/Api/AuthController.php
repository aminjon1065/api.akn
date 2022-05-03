<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => '|required|string|min:6|confirmed',
            'region' => 'required|string',
            'position' => 'required|string',
            'department' => 'required|string',
            'rank' => 'required|string',
            'signature' => 'required|image',
            'avatar' => 'required|image',
//            'signature' => 'required|mimes:jpeg,bmp,png,pdf,docx,doc,xlsx, xls'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->messages()->toArray(),
            ], 409);
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Hash::make($request->password),
            'position' => $request->position,
            'rank' => $request->rank,
            $signature = $request->file('signature'),
            $signatureName = $request->name . '-' . time() . '.' . $signature->getClientOriginalExtension(),
            $signaturePath = public_path('/signatures'),
            $signature->move($signaturePath, $signatureName),
            'signature' => $signatureName,
            $image = $request->file('avatar'),
            $imageName = time() . '.' . $image->getClientOriginalName(),
            $imagePath = public_path('/avatars'),
            $image->move($imagePath, $imageName),
            'avatar' => $imageName,
            'department' => $request->department,
            'region' => $request->region,
        ];

        $user = User::create($data);
        $token = $user->createToken('__register_token')->plainTextToken;

        return response()->json([
            'status' => 'Success',
            'message' => 'success registered',
//            'data' => 'token: ' . $token . ' ',
            'data' => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        $attr = $request->validate([
            'email' => 'required|string|email',
            'password' => '|required|string|min:6',
        ]);

        if (!Auth::attempt($attr)) {
            return $this->error('Credentials not match', 401);
        }
        $token = auth()->user()->createToken('__sign_token')->plainTextToken;
        return response()->json([
            'status' => 'Success',
            'message' => 'success registered',
            'data' => $token
        ], 201);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'status' => 'Success',
            'message' => 'success logout',
        ], 204);
    }

    public function me()
    {
        return \auth()->user();
    }
}
