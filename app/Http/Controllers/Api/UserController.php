<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    public function index()
    {
        $users = QueryBuilder::for(User::class)
            ->paginate(10);

        return UserResource::collection($users);
    }

    public function update(Request $request) {}

    public function destroy(User $user)
    {
        $user->delete();

        return;
    }

    public function show(User $user) {}
}
