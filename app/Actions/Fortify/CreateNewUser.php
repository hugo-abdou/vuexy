<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateNewUser
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        request()->validate([
            'fullName' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => array_merge($this->passwordRules(), ['confirmed']),
            'avatar' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ]);
        $user = User::create([
            'fullName' => $input['fullName'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        return $user;
    }
}
