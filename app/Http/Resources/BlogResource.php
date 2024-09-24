<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
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
            'title' => $this->title,
            'category' => $this->subCategory,
            'description' => $this->description,
            'thumbnail' => asset('storage/' . $this->thumbnail),
            'created' => $this->created_at->translatedFormat('d F Y'),
        ];
    }
}
