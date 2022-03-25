<?php

namespace App\Actions\Fortify;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UpdateUserPassword
{
    use PasswordValidationRules;

    /**
     * Validate and update the user's password.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($user, array $input)
    {
        Validator::make($input, [
            'current_password' => ['required', 'string'],
            'password' => array_merge($this->passwordRules(), ['confirmed'])
        ])->after(function ($validator) use ($user, $input) {
            if (!isset($input['current_password']) || !Hash::check($input['current_password'], $user->password)) {
                $validator->errors()->add('current_password', __('The provided password does not match your current password.'));
            }
        });

        $user->forceFill([
            'password' => Hash::make($input['password']),
        ])->save();
    }
}
