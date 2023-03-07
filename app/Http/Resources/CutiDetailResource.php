<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CutiDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'writer' => $this->whenLoaded('writer'),
            'start_date' => $this->start_date,
            'end_date' => $this->start_date,
            'reason' => $this->reason,
            'status' => $this->status,
            'created_at' => date_format($this->created_at, "Y/m/d H:i:s"),
        ];
    }
}
