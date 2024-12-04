<?php

namespace App\Services;

use App\Contracts\Interfaces\Auth\UserInterface;
use App\Contracts\Interfaces\ChallengeSubmitInterface;
use App\Contracts\Interfaces\IndustryClass\StudentInterface;
use App\Http\Requests\PointChallengeSubmitRequest;
use App\Http\Requests\ChallengeSubmitRequest;
use App\Enums\ChallengeSubmitEnum;
use App\Traits\ChallengeTrait;
use App\Models\Challenge;
use App\Models\ChallengeSubmit;
use App\Models\Student;

class ChallengeSubmitService
{  
    use ChallengeTrait;
    private StudentInterface $student;
    private UserInterface $user;
    private ChallengeSubmitInterface $challengeSubmit;

    public function __construct(StudentInterface $student, UserInterface $user, ChallengeSubmitInterface $challengeSubmit)
    {
        $this->challengeSubmit = $challengeSubmit;
        $this->student = $student;
        $this->user = $user;
    }

    public function store(ChallengeSubmitRequest $request, Challenge $challenge)
    {
        $data = $request->validated();
        $student = Student::where('user_id', auth()->user()->id)->first();

        $folderName = $this->makeDirectory($challenge->slug);
        $renameFile = $student->studentClassrooms()->latest()->first()->classroom->name . '-' . $student->user->name;

        if ($challenge->image_active == 1 && $request->hasFile('image')) {
            $dataImage = $this->renameFile($renameFile, $request->file('image'));
            $data['image'] = $request->file('image')->storeAs($folderName, $dataImage, 'public');
        }

        if ($challenge->file_active == 1 && $request->hasFile('file')) {
            $dataFile = $this->renameFile($renameFile, $request->file('file'));
            $data['file'] = $request->file('file')->storeAs($folderName, $dataFile, 'public');
        }

        $data['link'] = $challenge->link_active == 1 ? $data['link'] : null;
        $data['student_id'] = $student->id;
        $data['challenge_id'] = $challenge->id;

        return $data;
    }

    public function update(ChallengeSubmitRequest $request, ChallengeSubmit $challengeSubmit)
    {
        $data = $request->validated();
        $student = Student::where('user_id', auth()->user()->id)->first();

        $folderName = $this->makeDirectory($challengeSubmit->challenge->slug);
        $renameFile = $student->studentClassrooms()->latest()->first()->classroom->name . '-' . $student->user->name;

        if ($challengeSubmit->challenge->image_active == 1 && $request->hasFile('image')) {
            $this->remove($challengeSubmit->image);
            $dataImage = $this->renameFile($renameFile, $request->file('image'));
            $data['image'] = $request->file('image')->storeAs($folderName, $dataImage, 'public');
        } else {
            $data['image'] = $challengeSubmit->image;
        }

        if ($challengeSubmit->challenge->file_active == 1 && $request->hasFile('file')) {
            $this->remove($challengeSubmit->file);
            $dataImage = $this->renameFile($renameFile, $request->file('file'));
            $data['file'] = $request->file('file')->storeAs($folderName, $dataImage, 'public');
        } else {
            $data['file'] = $challengeSubmit->file;
        }

        if ($challengeSubmit->challenge->link_active == 1 && $request->input('link')) {
            $data['link'] = $data['link'];
        } else {
            $data['link'] = $challengeSubmit->link;
        }
        
        return $data;
    }

    public function delete(ChallengeSubmit $challengeSubmit)
    {
        $this->remove($challengeSubmit->image);
        $this->remove($challengeSubmit->file);
    }

    public function add_point(PointChallengeSubmitRequest $request, Challenge $challenge)
    {
        $data = $request->validated();

        foreach ($data['challenge_submit'] as $challenge_submit) {
            $student = Student::where('id', $challenge_submit['student_id'])->first();
            $this->user->updateMentor($student->user_id, ['point' => ($student->user->point + $challenge_submit['point'])]);
            $this->challengeSubmit->updateByChallenge($challenge->id, $student->id, ['point' => $challenge_submit['point'], 'status' => ChallengeSubmitEnum::CONFIRMED->value]);
        }
    }
}
