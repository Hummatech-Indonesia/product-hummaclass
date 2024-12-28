<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\Configuration\TermConditionInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\TermConditionRequest;
use App\Http\Resources\TermConditionResource;
use Illuminate\Http\JsonResponse;

class TermConditionController extends Controller
{
    private TermConditionInterface $termCondition;
    public function __construct(TermConditionInterface $termCondition)
    {
        $this->termCondition = $termCondition;
    }
    /**
     * Method show
     *
     * @return JsonResponse
     */
    public function show(): JsonResponse
    {
        return ResponseHelper::success(TermConditionResource::make($this->termCondition->show()), trans('alert.fetch_success'));
    }
    /**
     * Method update
     *
     * @param ContactRequest $request [explicite description]
     *
     * @return JsonResponse
     */
    public function update(TermConditionRequest $request): JsonResponse
    {
        $this->termCondition->update($request->validated());
        return ResponseHelper::success(null, trans('alert.update_success'));
    }
}
