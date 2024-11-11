<?php

namespace App\Http\Resources\IndustryClass;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SchoolResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'address' => $this->address,
            'head_master' => $this->head_master,
            'photo' => $this->photo,
            'description' => $this->description,
            'phone_number' => $this->phone_number
        ];
    }
}
