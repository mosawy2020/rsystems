<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class UrlResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "url" => $this->url,
            "shor_url" => Url("/Api")."/shortened/".$this->code,
            "exit_page" => Url("/Api")."/html/".$this->code,
            "is_active" => $this->is_active??1,
            "visits_number" => $this->visits_number??0,
            "user_id" => $this->user_id,
            "valid_till" => $this->valid_till,
            "updated_at" => $this->updated_at,
            "created_at" => $this->created_at,
        ];
    }
}
