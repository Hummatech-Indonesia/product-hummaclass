<?php

namespace App\Http\Resources\IndustryClass;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssesmentFormResource extends JsonResource
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
            'class_level' => $this->class_level,
            'division_id' => $this->division_id,
            'indicator' => $this->indicator
        ];
    }
}
