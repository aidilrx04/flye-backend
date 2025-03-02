<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
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

    public function update(Request $request) {}

    public function destroy(User $user)
    {
        Gate::authorize('delete', $user);

        $user->delete();

        return;
    }

    public function show(User $user) {}
}
