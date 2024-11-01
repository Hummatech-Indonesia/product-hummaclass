<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RewardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'image' => asset('storage/' . $this->image),
            'name' => $this->name,
            'slug' => $this->slug,
            'stock' => $this->stock,
            'points_required' => $this->points_required,
            'description' => $this->description,
        ];
    }
}
