<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            "header" => [
                'coverImg' => '/images/profile/post-media/2.jpg',
                "fullName" => $this->fullName,
                "avatar" => $this->ProfilePhotoUrl,
                "role" => "admin"
            ],
            "userAbout" => [
                "about" => $this->bio,
                "joined" => Carbon::make($this->created_at)->isoFormat('LL'),
                "lives" => $this->country ? $this->country : '',
                "email" => $this->email,
            ],
            "latestImages" => [
                ["img" => '/images/profile/user-uploads/user-13.jpg']
            ],
            "suggestions" => [
                [
                    "avatar" => "/images/portrait/small/avatar-s-10.jpg",
                    "name" => "Jonathan Lyons",
                    "mutualFriend" => "25 Mutual Friends",
                ]
            ],
            "suggestedPages" => [
                [
                    "avatar" => "/images/avatars/12-small.png",
                    "fullName" => "Peter Reed",
                    "subtitle" => "Company",
                    "favorite" => false,
                ]
            ],
            "twitterFeeds" => [
                [
                    "imgUrl" => "/images/avatars/1-small.png",
                    "title" => "Norman Gross",
                    "id" => "tiana59 ",
                    "tags" => "#sketch #uiux #figma",
                    "desc" => "Candy jelly beans powder brownie biscuit. Jelly marzipan oat cake cake.",
                    "favorite" => false,
                ]
            ],
            "polls" => [
                [
                    "name" => "RDJ",
                    "result" => "82%",
                    "votedUser" => [
                        [
                            "img" => "/images/portrait/small/avatar-s-12.jpg",
                            "fullName" => "Tonia Seabold",
                        ],
                        [
                            "img" => "/images/portrait/small/avatar-s-5.jpg",
                            "fullName" => "Carissa Dolle",
                        ],
                    ],
                ]
            ],
            "posts" => [
                [
                    "avatar" => "/images/portrait/small/avatar-s-18.jpg",
                    "fullName" => "Leeanna Alvord",
                    "postTime" => "12 Dec 2018 at 1:16 AM",
                    "postText" =>
                    "Wonderful Machine· A well-written bio allows viewers to get to know a photographer beyond the work. This can make the difference when presenting to clients who are looking for the perfect fit.",
                    "postImg" => "/images/profile/post-media/2.jpg",
                    "likes" => 1240,
                    "youLiked" => true,
                    "comments" => 1240,
                    "share" => 1240,
                    "likedCount" => 140,
                    "likedUsers" => [
                        [
                            "avatar" => "/images/portrait/small/avatar-s-5.jpg",
                            "fullName" => "George Nordic",
                        ],
                        [
                            "avatar" => "/images/portrait/small/avatar-s-4.jpg",
                            "fullName" => "Vinnie Mostowy",
                        ]
                    ],
                    "detailedComments" => [
                        [
                            "avatar" => "/images/portrait/small/avatar-s-6.jpg",
                            "fullName" => "Kitty Allanson",
                            "comment" =>
                            "Easy & smart fuzzy search🕵🏻 functionality which enables users to search quickly.",
                            "commentsLikes" => 34,
                            "youLiked" => false,
                        ],
                    ],
                ]
            ]
        ];
    }
}
