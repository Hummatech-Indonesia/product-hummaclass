<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseHelper;
use App\Services\TripayService;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class TripayCallback
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return Response|RedirectResponse|JsonResponse
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse|JsonResponse
    {
        // dd(TripayService::handleGenerateCallbackSignature($request), $request->header('X-Callback-Signature'));
        if (TripayService::handleGenerateCallbackSignature($request) !== $request->header('X-Callback-Signature')) {
            ResponseHelper::error(null, trans('alert.invalid_callback_signature'), ResponseCode::HTTP_FORBIDDEN);
        }

        if ('payment_status' !== $request->header('X-Callback-Event')) {
            ResponseHelper::error(null, trans('alert.invalid_callback_event'), ResponseCode::HTTP_FORBIDDEN);
        }

        return $next($request);

    }
}
