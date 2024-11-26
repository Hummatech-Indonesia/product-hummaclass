<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TopCourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'sub_category' => $this->subCategory->name,
            'category' => $this->subCategory->category->name,
            'title' => $this->title,
            'sub_title' => $this->sub_title,
            'description' => $this->description,
            'slug' => $this->slug,
            'is_premium' => $this->is_premium,
            'price' => $this->price,
            'promotional_price' => $this->promotional_price,
            'photo' => url('storage/' . $this->photo),
            'rating' => $this->courseReviews->avg('rating'),
        ];
    }
}
