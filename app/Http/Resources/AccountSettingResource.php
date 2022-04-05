<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AccountSettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "general" => [
                'fullName' => $this->fullName,
                'email' => $this->email,
                'avatar' => $this->profilePhotoUrl,
                'emailConfirmed' => is_null($this->email_verified_at),
                'birth_date' => $this->birth_date,
                'phone' => $this->phone,
                'country' => $this->country,
                'bio' => $this->bio
            ]
        ];
    }
}
