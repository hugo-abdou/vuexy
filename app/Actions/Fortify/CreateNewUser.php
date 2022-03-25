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
        Validator::make($input, [
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => array_merge($this->passwordRules(), ['confirmed']),
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        return $user;
    }
}
