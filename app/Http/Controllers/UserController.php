<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\GetUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\RemoveUserRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function get(GetUserRequest $request)
    {
        $validated = $request->validated();

        $user = User::findOrFail($validated['id']);

        if (Auth::user()->cannot('get', $user)) {
            return response(['message' => __('validation.custom.not_enough_rights')], 403);
        }

        return response()->json($user);
    }

    public function update(UpdateUserRequest $request)
    {
        $validated = $request->validated();

        $user = User::findOrFail($validated['id']);

        if (Auth::user()->cannot('update', $user)) {
            return response(['message' => __('validation.custom.not_enough_rights')], 403);
        }

        if (isset($validated['password']))
            $validated['password'] = Hash::make($validated['password']);


        $user->update($validated);

        return response()->json($user);
    }

    public function remove(RemoveUserRequest $request)
    {
        $validated = $request->validated();

        $user = User::findOrFail($validated['id']);

        if (Auth::user()->cannot('remove', $user)) {
            return response(['message' => __('validation.custom.not_enough_rights')], 403);
        }

        $user->delete();

        return response()->json(['message' => 'The user was deleted successfully']);
    }
}
