<?php

namespace App\Contracts\Repositories\IndustryClass;

use App\Contracts\Interfaces\IndustryClass\AttendanceInterface;
use App\Contracts\Interfaces\IndustryClass\LearningPathInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\Attendance;
use App\Models\LearningPath;

class LearningPathRepository extends BaseRepository implements LearningPathInterface
{
    public function __construct(LearningPath $learningPath)
    {
        $this->model = $learningPath;
    }
    public function get(): mixed
    {
        return $this->model->query()->get();
    }
    public function store(array $data): mixed
    {
        return $this->model->query()->create($data);
    }
    public function show(mixed $id): mixed
    {
        return $this->model->query()->findOrFail($id);
    }
    public function update(mixed $id, array $data): mixed
    {
        return $this->show($id)->update($data);
    }
    public function delete(mixed $id): mixed
    {
        return $this->show($id)->delete();
    }
}
