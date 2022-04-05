<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UpdateUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($user, array $input)
    {
        $data = Validator::make($input, $this->validation_rules($user, $input))->validate();
        $filtered = Arr::except($data, ['avatar']);

        if (isset($input['avatar']) && is_file($input['avatar'])) {
            $user->updateProfilePhoto($input['avatar']);
        }

        if (
            $input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail
        ) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill($filtered)->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill(array_merge($this->validation_rules($user, $input), [
            'email_verified_at' => null,
        ]))->save();
        // $user->sendEmailVerificationNotification();
    }

    protected function validation_rules($user, array $input)
    {
        return [
            'fullName' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'avatar' => Rule::when(is_file($input['avatar']), ['required', 'mimes:jpg,jpeg,png', 'max:1024']),
            'bio' =>  ['required', 'string', 'max:255'],
            'phone' =>  ['required', 'string', 'max:255'],
            'birth_date' =>  ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
        ];
    }
}
