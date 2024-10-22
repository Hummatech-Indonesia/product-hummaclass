<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ModuleTaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = \Laravel\Sanctum\PersonalAccessToken::findToken(substr($request->header('authorization'), 7, 100))?->tokenable()->first();

        return [
            'id' => $this->id,
            'module' => $this->module,
            'question' => $this->question,
            'description' => $this->description,
            'point' => $this->point,
            'is_finish' => $this->submissionTask()->where('user_id', $user?->id)->count() > 0
        ];
    }
}
