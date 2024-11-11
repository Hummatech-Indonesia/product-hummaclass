<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailSchoolResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $this->load(['classrooms.division']);
        $resource = parent::toArray($request);
        $resource['photo'] = url('certificate/serti-bg.png');
        return $resource;
    }
}
