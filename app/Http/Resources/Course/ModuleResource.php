<?php

namespace App\Http\Resources\Course;

use App\Http\Resources\SubModuleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ModuleResource extends JsonResource
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
            'sub_title' => $this->sub_title,
            'course' => $this->course->title,
            'sub_modules' => SubModuleResource::collection($this->subModules),
        ];
    }
}
