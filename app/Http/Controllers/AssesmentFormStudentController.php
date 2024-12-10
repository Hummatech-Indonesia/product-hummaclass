<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\IndustryClass\AssesmentFormStudentInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\IndustryClass\AssesmentFormStudentRequest;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AssesmentFormStudentController extends Controller
{
    private AssesmentFormStudentInterface $assesmentFormStudent;

    public function __construct(AssesmentFormStudentInterface $assesmentFormStudent)
    {
        $this->assesmentFormStudent = $assesmentFormStudent;
    }


    /**
     * post
     *
     * @param  mixed $student
     * @return JsonResponse
     */
    public function post(AssesmentFormStudentRequest $erquest, Student $student): JsonResponse
    {
        for ($i = 1; $i <= count($erquest->assessment_form_id); $i++) {
            $this->assesmentFormStudent->store([
                'assessment_form_id' => $erquest->assessment_form_id[$i],
                'value' => $erquest->value[$i],
                'student_id' => $student->id
            ]);
        }

        return ResponseHelper::success(null, trans('alert.add_success'));
    }
}
