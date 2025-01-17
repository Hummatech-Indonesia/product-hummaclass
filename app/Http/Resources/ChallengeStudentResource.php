<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChallengeStudentResource extends JsonResource
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
            'school' => $this->classroom->school->name,
            'classroom' => $this->classroom->name,
            'description' => $this->description,
            'start_date' => Carbon::parse($this->start_date)->translatedFormat('d F Y - H:i'),
            'end_date' => Carbon::parse($this->end_date)->translatedFormat('d F Y - H:i'),
            'title' => $this->title,
            'slug' => $this->slug,
            'status' => $this->challengeSubmits()->whereRelation('student', 'user_id', auth()->user()->id)->first() ? 'Sudah Dikerjakan' : 'Belum Dikerjakan',
            'color' => $this->challengeSubmits()->whereRelation('student', 'user_id', auth()->user()->id)->first() ? 'bg-light-primary text-primary' : 'bg-light-danger text-danger',
            'image_active' => $this->image_active,
            'file_active' => $this->file_active,
            'link_active' => $this->link_active,
        ];
    }
}
