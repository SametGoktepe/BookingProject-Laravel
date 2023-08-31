<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'avatar' => $this->avatar ?? '/storage/avatars/default.png',
            'role' => $this->role->name ?? null,
            'address' => AddressResource::make($this->address) ?? [],
            'birthday' => Carbon::parse($this->dob)->format('d-m-Y'),
            'register_date' => $this->created_at->format('d-m-Y'),
       ];
    }
}
