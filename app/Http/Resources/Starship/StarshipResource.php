<?php

namespace App\Http\Resources\Starship;

use Illuminate\Http\Resources\Json\JsonResource;

class StarshipResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name
        ];
    }
}
