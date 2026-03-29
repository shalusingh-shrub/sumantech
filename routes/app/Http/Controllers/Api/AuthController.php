<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // =============================================
    // POST /api/signup
    // Register karo naya user
    // =============================================
    public function signup(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone'    => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $token = Str::random(60);

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'phone'     => $request->phone,
            'api_token' => hash('sha256', $token),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Account successfully bana diya gaya!',
            'token'   => $token,
            'user'    => [
                'id'          => $user->id,
                'name'        => $user->name,
                'email'       => $user->email,
                'phone'       => $user->phone,
                'designation' => $user->designation,
                'department'  => $user->department,
                'is_active'   => $user->is_active,
                'created_at'  => $user->created_at,
            ],
        ], 201);
    }

    // =============================================
    // POST /api/login
    // Login karo aur token lo
    // =============================================
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email ya password galat hai.',
            ], 401);
        }

        if (!$user->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Aapka account band kar diya gaya hai. Admin se sampark karein.',
            ], 403);
        }

        // Naya token generate karo
        $token = Str::random(60);

        $user->update([
            'api_token' => hash('sha256', $token),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Login successful!',
            'token'   => $token,
            'user'    => [
                'id'          => $user->id,
                'name'        => $user->name,
                'email'       => $user->email,
                'phone'       => $user->phone,
                'designation' => $user->designation,
                'department'  => $user->department,
                'avatar'      => $user->avatar,
                'is_active'   => $user->is_active,
                'created_at'  => $user->created_at,
            ],
        ]);
    }

    // =============================================
    // GET /api/user
    // Token se logged-in user ki info lo
    // =============================================
    public function userInfo(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json([
            'success' => true,
            'message' => 'User information mili!',
            'user'    => [
                'id'          => $user->id,
                'name'        => $user->name,
                'email'       => $user->email,
                'phone'       => $user->phone,
                'designation' => $user->designation,
                'department'  => $user->department,
                'about'       => $user->about,
                'avatar'      => $user->avatar,
                'is_active'   => $user->is_active,
                'roles'       => $user->getRoleNames(),
                'created_at'  => $user->created_at,
                'updated_at'  => $user->updated_at,
            ],
        ]);
    }

    // =============================================
    // POST /api/logout
    // Token delete karo (logout)
    // =============================================
    public function logout(Request $request): JsonResponse
    {
        $request->user()->update(['api_token' => null]);

        return response()->json([
            'success' => true,
            'message' => 'Logout ho gaye! Token delete kar diya gaya.',
        ]);
    }
}
