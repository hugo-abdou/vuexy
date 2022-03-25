<?php

namespace App\Actions\Fortify;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ResetUserPassword
{
    use PasswordValidationRules;

    /**
     * Validate and reset the user's forgotten password.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function reset($user, array $input)
    {
        Validator::make($input, [
            'password' => array_merge($this->passwordRules(), ['confirmed']),
        ])->validate();

        $user->forceFill([
            'password' => Hash::make($input['password']),
        ])->save();
    }
}
