<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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

            'id'=>$this->id,
            'code'=> $this->code->code,
            'icon'=>$this->icon,
            'name'=>$this->name,
            'lat'=>$this->lat,
            'long'=>$this->long,
            'country'=>$this->country,
            'city'=>$this->city,
            'street'=>$this->street,
            'build_number'=>$this->build_number,
            'house_number'=>$this->house_number,
            'floor_number'=>$this->floor_number,
            'note'=>$this->note,
            // 'code'=> new CodeResource($this?->code),

        ];
    }
}
