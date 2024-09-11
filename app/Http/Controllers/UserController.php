<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\GetUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\RemoveUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function get(GetUserRequest $request)
    {
        $validated = $request->validated();

        return response()->json(User::findOrFail($validated['id']));
    }

    public function update(UpdateUserRequest $request)
    {
        $validated = $request->validated();

        if (isset($validated['password']))
            $validated['password'] = Hash::make($validated['password']);

        $user = User::findOrFail($validated['id']);

        $user->update($validated);

        return response()->json($user);
    }

    public function remove(RemoveUserRequest $request)
    {
        $validated = $request->validated();

        $user = User::findOrFail($validated['id']);

        $user->delete();

        return response()->json(['message' => 'The user was deleted successfully']);
    }
}
