<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubModuleResource extends JsonResource
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
            'module' => $this->module->title,
            'title' => $this->title,
            'sub_title' => $this->sub_title,
            'content' => $this->content,
            'url_youtube' => $this->url_youtube,
        ];
    }
}
