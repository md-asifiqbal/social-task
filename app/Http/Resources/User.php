<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'userId' => $this->id,
            'name' => $this->full_name,
            'email' => $this->email,
            'follow'=>auth()->check() && auth()->user()->isFollowing($this->id)?1:0
        ];
    }
}
