<?php

namespace App\Http\Controllers;

use App\Events\UserRegisteredEvent;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RegisterUserController extends Controller
{
    public function __invoke(RegisterUserRequest $request)
    {
        DB::beginTransaction();

        $user = new User($request->validated());
        $user->save();
        event(new UserRegisteredEvent($user));

        DB::commit();

        return response()->json($user, 201);
    }
}
