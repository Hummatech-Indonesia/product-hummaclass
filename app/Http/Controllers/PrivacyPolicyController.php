<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\Configuration\PrivacyPolicyInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\PrivacyPolicyRequest;
use App\Http\Resources\PrivacyPolicyResource;
use Illuminate\Http\JsonResponse;

class PrivacyPolicyController extends Controller
{
    private PrivacyPolicyInterface $privacyPolicy;
    public function __construct(PrivacyPolicyInterface $privacyPolicy)
    {
        $this->privacyPolicy = $privacyPolicy;
    }
    /**
     * Method show
     *
     * @return JsonResponse
     */
    public function show(): JsonResponse
    {
        return ResponseHelper::success(PrivacyPolicyResource::make($this->privacyPolicy->show()), trans('alert.fetch_success'));
    }
    /**
     * Method update
     *
     * @param ContactRequest $request [explicite description]
     *
     * @return JsonResponse
     */
    public function update(PrivacyPolicyRequest $request): JsonResponse
    {
        $this->privacyPolicy->update($request->validated());
        return ResponseHelper::success(null, trans('alert.update_success'));
    }
}
