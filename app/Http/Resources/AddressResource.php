<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return [
            'id' => $this->id,
            'city' => $this->city->name ?? null,
            'state' => $this->state->name ?? null,
            'country' => $this->country->name ?? null,
            'address' => $this->address ?? null,
            'default' => $this->default == 1 ? true : false,
        ];
    }
}
