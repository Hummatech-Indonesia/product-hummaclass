<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\ChallengeSubmitInterface;
use App\Models\ChallengeSubmit;

class ChallengeSubmitRepository extends BaseRepository implements ChallengeSubmitInterface
{
    public function __construct(ChallengeSubmit $challengeSubmit)
    {
        $this->model = $challengeSubmit;
    }
    public function get(): mixed
    {
        return $this->model->query()->get();
    }

    public function getByStudent(array $data): mixed
    {
        return $this->model->query()
            ->whereRelation('student', 'user_id', $data['user_id'])
            ->where('challenge_id', $data['challenge_id'])
            ->get();
    }

    public function getByMentor(mixed $id): mixed
    {
        return $this->model->query()->where('challenge_id', $id)->get();
    }   

    public function getByTeacher(mixed $id): mixed
    {
        return $this->model->query()->whereRelation('challenge', 'classroom_id', $id)->get();
    }

    /**
     * Method store
     *
     * @param array $data [explicite description]
     *
     * @return mixed
     */
    public function store(array $data): mixed
    {
        return $this->model->query()->create($data);
    }
    /**
     * Method show
     *
     * @param mixed $id [explicite description]
     *
     * @return mixed
     */
    public function show(mixed $id): mixed
    {
        return $this->model->query()->findOrFail($id);
    }
    /**
     * Method update
     *
     * @param mixed $id [explicite description]
     * @param array $data [explicite description]
     *
     * @return mixed
     */
    public function update(mixed $id, array $data): mixed
    {
        return $this->model->query()->findOrFail($id)->update($data);
    }

    /**
     * showWithCourse
     *
     * @param  mixed $id
     * @return mixed
     */
    public function delete(mixed $id): mixed
    {
        return $this->model->query()->findOrFail($id)->delete();
    }
}