<?php

namespace App\Http\Controllers\Api;

use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Http\Controllers\Controller;
use App\Http\Resources\AccountSettingResource;
use App\Http\Resources\AuthUserResource;
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

    public function update_auth_general_details(Request $request, UpdateUserProfileInformation $profile, UpdateUserPassword $password)
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
