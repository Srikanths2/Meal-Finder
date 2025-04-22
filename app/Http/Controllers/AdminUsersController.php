<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest; 
use App\Http\Requests\ChangeUserRoleRequest;
use App\Http\Resources\UserResponse;

class AdminUsersController extends Controller
{
    //  List all users
    public function index()
    {
        $users = User::all();
        return new UserResponse($users);
    }

    //  Show specific user
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return new UserResponse($user);
    }

    //  Create new user
    public function create(CreateUserRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        return response()->json([
            'message' => 'User created successfully',
            'user' => new UserResponse($user)
        ], 201);
    }

    //  Update existing user
    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $validated = $request->validated();

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return response()->json([
            'message' => 'User updated successfully',
            'user' => new UserResponse($user)
        ]);
    }

    //  Delete user
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], 204);
    }

    //  Change user role
    public function changeRole(ChangeUserRoleRequest $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->role = $request->validated()['role'];
        $user->save();

        return response()->json([
            'message' => 'User role updated successfully',
            'user' => new UserResponse($user)
        ]);
    }
}
