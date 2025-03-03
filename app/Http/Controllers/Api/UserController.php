<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', User::class);

        $users = QueryBuilder::for(User::class)
            ->paginate(10);

        return UserResource::collection($users);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        Gate::authorize('update', $user);

        $safe = $request->safe();

        $user->update($safe->only(['full_name']));

        if ($safe->password) {
            $user->update([
                'password' => Hash::make($safe->password)
            ]);
        }

        return new UserResource($user);
    }

    public function destroy(User $user)
    {
        Gate::authorize('delete', $user);

        $user->delete();

        return;
    }

    public function show(User $user)
    {
        Gate::authorize('view', $user);
        return new UserResource($user);
    }
}
