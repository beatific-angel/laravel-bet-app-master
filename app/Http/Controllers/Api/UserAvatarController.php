<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserAvatarStoreRequest;
use App\Http\Resources\UserResource;

class UserAvatarController extends Controller
{
    /**
     * @param UserAvatarStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserAvatarStoreRequest $request)
    {
        $user = $request->user();

        /** @var \Illuminate\Http\UploadedFile|null $file */
        $file = $request->file('avatar');

        if ($file) {
            $file->storeAs('avatars', $user->id .'.'. $file->getClientOriginalExtension());
        }

        return UserResource::make($user)
            ->response()
            ->setStatusCode(config('httpstatus.created'));
    }
}
