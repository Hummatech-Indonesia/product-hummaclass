<?php

namespace App\Services;

use App\Contracts\Interfaces\Auth\UserInterface;
use App\Http\Requests\StoreMentorRequest;
use App\Http\Requests\UpdateMentorRequest;
use App\Models\Mentor;

class MentorService
{
    private UserInterface $user;
    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }
    
    public function store(StoreMentorRequest $request): bool|array
    {
        $data = $request->validated();
        $user =  $this->user->createMentor($data);

        $data['user_id'] = $user->id;

        return $data;
    }

    public function update(UpdateMentorRequest $request, Mentor $mentor): bool|array
    {
        $data = $request->validated();
        $this->user->updateMentor($mentor->user->id, $data);

        return $data;
    }
}
