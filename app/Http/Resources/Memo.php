<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Memo extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'destination_id'=>$this->destination_id,
            'content'=>$this->content,
            // 'date'=>$this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
