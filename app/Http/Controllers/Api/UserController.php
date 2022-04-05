<?php

namespace App\Http\Controllers\Api;

use App\Actions\Fortify\UpdateUserPassword as Password;
use App\Actions\Fortify\UpdateUserProfileInformation as Profile;
use App\Http\Controllers\Controller;
use App\Http\Resources\AccountSettingResource;
use App\Http\Resources\AuthUserResource;
use App\Http\Resources\ProfileResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function auth()
    {
        return new AuthUserResource(auth()->user());
    }

    public function auth_details(Request $request)
    {
        return new AccountSettingResource(auth()->user());
    }

    public function update(Request $request, Profile $profile, Password $password)
    {
        if (!$request->has("action")) return response("error", 400);
        
        switch ($request->get("action")) {
            case 'general':
                $profile->update(auth()->user(), $request->all());
                break;
            case 'password':
                $password->update(auth()->user(), $request->all());
                break;
            case 'reset_avatar':
                auth()->user()->deleteProfilePhoto();
                break;

            default:
                break;
        }

        return response("success", 200);
    }

    public function profile()
    {
        $data = collect(new ProfileResource(auth()->user()));
        try {
            return $data[request('component')];
        } catch (\Throwable $th) {
            return response(['message' => 'component resource not found'], 400);
        }
    }
}
