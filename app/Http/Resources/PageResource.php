<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
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
            'userId' => $this->user_id,
            'page_name' => $this->page_name,
            'pageId' => $this->id,
            'total_post'=>count($this->posts),
            'follow'=>auth()->check() && auth()->user()->isPageFollowing($this->id)?1:0
        ];
    }
}
