<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\ChallengeInterface;
use App\Models\Challenge;

class ChallengeRepository extends BaseRepository implements ChallengeInterface
{
    public function __construct(Challenge $challenge)
    {
        $this->model = $challenge;
    }

    public function get(): mixed
    {
        return $this->model->query()->where('user_id', auth()->user()->id)->get();
    }

    public function getByClassroom(string $classroomSlug): mixed
    {
        return $this->model->query()->whereRelation('classroom', 'slug', $classroomSlug)->get();
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

    public function showWithSlug(string $slug): mixed
    {
        return $this->model->query()->where('slug', $slug)->first();
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
