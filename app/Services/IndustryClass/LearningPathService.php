<?php

namespace App\Services\IndustryClass;

use App\Contracts\Interfaces\IndustryClass\CourseLearningPathInterface;
use App\Contracts\Interfaces\IndustryClass\LearningPathInterface;
use App\Http\Requests\AttendanceRequest;
use App\Http\Requests\LearningPathRequest;
use App\Models\Attendance;
use App\Models\LearningPath;

class LearningPathService
{
    private LearningPathInterface $learningPath;
    private CourseLearningPathInterface $courseLearningPath;
    public function __construct(CourseLearningPathInterface $courseLearningPath, LearningPathInterface $learningPath)
    {
        $this->courseLearningPath = $courseLearningPath;
        $this->learningPath = $learningPath;
    }
    public function store(LearningPathRequest $request): bool
    {
        $data = $request->validated();

        $condition = $this->learningPath->whereDivision($data['division_id'], $data['class_level']);

        if ($condition) {
            $learningPath = $condition;
        } else {
            $learningPath = $this->learningPath->store($data);
        }

        foreach ($data['course_id'] as $index => $courseId) {

            $courseLearningPath = $this->courseLearningPath->whereCourse($courseId, $learningPath->id);

            if ($courseLearningPath) {
                $this->courseLearningPath->delete($courseLearningPath->id);
            }

            $courseLearningPathData = [
                'learning_path_id' => $learningPath->id,
                'course_id' => $courseId,
                'step' => $index + 1
            ];
            $this->courseLearningPath->store($courseLearningPathData);
        }
        return true;
    }
    public function update(LearningPathRequest $request, LearningPath $learningPath): bool
    {
        $data = $request->validated();
        $learningPath->update($data);
        $this->courseLearningPath->deleteWhere(['learning_path_id' => $learningPath->id]);
        foreach ($data['course_id'] as $index => $courseId) {
            $courseLearningPathData = [
                'learning_path_id' => $learningPath->id,
                'course_id' => $courseId,
                'step' => $index + 1
            ];
            $this->courseLearningPath->store($courseLearningPathData);
        }
        return true;
    }
}
