<?php

namespace App\Http\Controllers\IndustryClass;

use App\Contracts\Interfaces\IndustryClass\AssesmentFormInterface;
use App\Enums\TypeAssesmentEnum;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\IndustryClass\AssesmentFormRequest;
use App\Http\Resources\IndustryClass\AssesmentFormResource;
use App\Models\Division;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AssesmentFormController extends Controller
{
    private AssesmentFormInterface $assementForm;

    public function __construct(AssesmentFormInterface $assementForm)
    {
        $this->assementForm = $assementForm;
    }

    /**
     * index
     *
     * @param  mixed $division
     * @param  mixed $classLevel
     * @return JsonResponse
     */
    public function index(Division $division, string $classLevel): JsonResponse
    {
        $data['assementFormAttitudes'] = AssesmentFormResource::collection($this->assementForm->getWhere(['division_id' => $division->id, 'class_level' => $classLevel, 'type' => TypeAssesmentEnum::ATTITUDE->value]));
        $data['assementFormSkills'] = AssesmentFormResource::collection($this->assementForm->getWhere(['division_id' => $division->id, 'class_level' => $classLevel, 'type' => TypeAssesmentEnum::SKILL->value]));
        return ResponseHelper::success($data);
    }

    /**
     * store
     *
     * @return JsonResponse
     */
    public function store(AssesmentFormRequest $request, Division $division, string $classLevel, string $type): JsonResponse
    {
        $assementForm = $this->assementForm->deleteWhere(['class_level' => $classLevel, 'division_id' => $division->id, 'type' => $type]);

        foreach ($request->indicator as $indicator) {
            $this->assementForm->store([
                'class_level' => $classLevel,
                'division_id' => $division->id,
                'indicator' => $indicator,
                'type' => $type
            ]);
        }
        return ResponseHelper::success(null, trans('alert.add_success'));
    }
}
