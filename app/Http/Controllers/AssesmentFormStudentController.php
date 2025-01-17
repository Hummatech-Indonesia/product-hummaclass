<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\IndustryClass\AssesmentFormInterface;
use App\Contracts\Interfaces\IndustryClass\AssesmentFormStudentInterface;
use App\Enums\TypeAssesmentEnum;
use App\Helpers\ResponseHelper;
use App\Http\Requests\IndustryClass\AssesmentFormStudentRequest;
use App\Http\Resources\AssesmentFormStudentResource;
use App\Http\Resources\IndustryClass\AssesmentFormResource;
use App\Http\Resources\StudentAssesmentResource;
use App\Models\Student;
use App\Models\StudentClassroom;
use App\Services\AssesmentFormService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AssesmentFormStudentController extends Controller
{
    private AssesmentFormStudentInterface $assesmentFormStudent;
    private AssesmentFormInterface $assementForm;
    private AssesmentFormService $assesmentFormService;

    public function __construct(AssesmentFormStudentInterface $assesmentFormStudent, AssesmentFormInterface $assementForm, AssesmentFormService $assesmentFormService)
    {
        $this->assesmentFormStudent = $assesmentFormStudent;
        $this->assementForm = $assementForm;
        $this->assesmentFormService = $assesmentFormService;
    }

    public function index(Request $request, $classroomId): mixed
    {
        $studentAssesments = $this->assesmentFormStudent->getStudentAssesment($request, $classroomId);
        return ResponseHelper::success(AssesmentFormStudentResource::collection($studentAssesments));
    }

    /**
     * post
     *
     * @param  mixed $student
     * @return JsonResponse
     */
    public function post(AssesmentFormStudentRequest $request, Student $student): JsonResponse
    {
        $data = $request->validated();
        foreach ($data['assessment_form_id'] as $index => $formId) {
            $studentFormData = [
                'assessment_form_id' => $formId,
                'value' => $data['value'][$index],
                'student_id' => $student->id
            ];
            $this->assesmentFormStudent->store($studentFormData);
        }

        return ResponseHelper::success(null, trans('alert.add_success'));
    }

    public function show(StudentClassroom $studentClassroom): JsonResponse
    {
        $data['assementFormAttitudes'] = StudentAssesmentResource::collection($this->assesmentFormStudent->getByStudent(['student_id' => $studentClassroom->student->id, 'division_id' => $studentClassroom->classroom->division->id, 'class_level' => $studentClassroom->classroom->class_level, 'type' => TypeAssesmentEnum::ATTITUDE->value]));
        $data['assementFormSkills'] = StudentAssesmentResource::collection($this->assesmentFormStudent->getByStudent(['student_id' => $studentClassroom->student->id, 'division_id' => $studentClassroom->classroom->division->id, 'class_level' => $studentClassroom->classroom->class_level, 'type' => TypeAssesmentEnum::SKILL->value]));

        return ResponseHelper::success($data);
    }

    public function downloadAssessmentPdf(StudentClassroom $studentClassroom)
    {
        $assementFormAttitudes = $this->assesmentFormStudent->getByStudent(['student_id' => $studentClassroom->student->id,'division_id' => $studentClassroom->classroom->division->id,'class_level' => $studentClassroom->classroom->class_level,'type' => TypeAssesmentEnum::ATTITUDE->value]);

        $assementFormSkills = $this->assesmentFormStudent->getByStudent(['student_id' => $studentClassroom->student->id,'division_id' => $studentClassroom->classroom->division->id,'class_level' => $studentClassroom->classroom->class_level,'type' => TypeAssesmentEnum::SKILL->value]);

        $totalAssesment = $this->assesmentFormService->totalAssesment($assementFormAttitudes, $assementFormSkills);
 
        $pdf = Pdf::loadView('pdf.studentAssesment', compact('studentClassroom', 'assementFormAttitudes', 'assementFormSkills', 'totalAssesment'));         

        return $pdf->download('penilaian ' . $studentClassroom->student->user->name . '-' . $studentClassroom->classroom->name . '.pdf');
    }
}
