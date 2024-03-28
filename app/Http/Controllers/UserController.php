<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Jobs\UserJob;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function newUser(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()->all()
            ], 400);
        }

        $user = new User();
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->status = $user::STATUS_IN_PROGRESS;

        $user->save();

        Queue::push(new UserJob($user));

        return response()->json([
            'error' => false,
            'message' => ['id' => $user->id]
        ]);
    }

    public function status(Request $request, int $id): JsonResponse
    {
        $validator = Validator::make([$id], [
            $id => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()->all()
            ], 400);
        }

        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'error' => true,
                'message' => 'User not found'
            ], 400);
        }

        return response()->json([
            'error' => false,
            'message' => [$user]
        ]);
    }
}
