<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Memo AS MemoResource;

class Destination extends JsonResource
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
            'name'=>$this->name,
            'lat'=>$this->lat,
            'lng'=>$this->lng,
            'photo'=>$this->photo,
            'memos' => MemoResource::collection($this->memos), //コレで該当destination_idのレコードが呼べる
        ];
    }
}
