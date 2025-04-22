<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\RegisterUserResponse;
use App\Http\Resources\LoginUserResponse;
use App\Http\Resources\ProfileResponse;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Resources\ChangePasswordResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    // ✅ Register new user
    public function register(RegisterUserRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        return response()->json([
            'message' => 'User registered successfully!',
            'user' => new RegisterUserResponse($user)
        ], 201);
    }

    // ✅ Login user
    public function login(LoginUserRequest $request)
    {
        $validated = $request->validated();

        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
            $user = Auth::user();

            return response()->json([
                'message' => 'Login successful!',
                'user' => new LoginUserResponse($user)
            ]);
        }

        return response()->json([
            'message' => 'Invalid credentials'
        ], 401);
    }

    // ✅ Show profile using ID (no session/token needed)
    public function showProfile($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'message' => 'User profile fetched successfully',
            'user' => new ProfileResponse($user)
        ]);
    }


    // ✅ Update profile using user ID (no session/token needed)
    public function updateProfile(UpdateProfileRequest $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        $validated = $request->validated();

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return response()->json([
            'message' => 'Profile updated successfully (by ID)',
            'user' => new ProfileResponse($user)
        ]);
    }

    // ✅ change password using user ID (no session/token needed)
    public function changePassword(ChangePasswordRequest $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Current password is incorrect'
            ], 400);
        }

        // Update to new password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return new ChangePasswordResponse(null);
    }


    // ✅ Logout user
    public function logout(Request $request)
    {
        // Auth::logout();
        // $request->session()->invalidate();
        // $request->session()->regenerateToken();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}
