<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController; // Add this line
use Illuminate\Validation\ValidationException;

class UserController extends BaseController // Change here to extend BaseController
{
    // Display a listing of users with their institute
    public function index()
    {
        $users = User::with('institute')->get();
        return response()->json($users);
    }

    // Store a new user
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8',
                'institute_id' => 'required|exists:institutes,id',
            ]);

            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'institute_id' => $validatedData['institute_id'],
            ]);
            
            return response()->json($user, 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->validator->errors()], 422);
        }
    }

    // Display the specified user with their institute
    public function show(User $user)
    {
        return response()->json($user->load('institute'));
    }

    // Update a user
    public function update(Request $request, User $user)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'sometimes|string|max:255',
                'email' => 'sometimes|email|unique:users,email,' . $user->id,
                'password' => 'sometimes|string|min:8',
                'institute_id' => 'sometimes|exists:institutes,id',
            ]);

            $user->update(array_filter($validatedData));
            return response()->json($user);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->validator->errors()], 422);
        }
    }

    // Delete a user
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
}