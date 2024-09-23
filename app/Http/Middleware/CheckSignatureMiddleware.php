<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Services\TripayService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class CheckSignatureMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse|JsonResponse
    {
        // dd(TripayService::handleGenerateCallbackSignature($request), $request->header('X-Callback-Signature'));
        if (TripayService::handleGenerateCallbackSignature($request) !== $request->header('X-Callback-Signature')) {
            ResponseHelper::error(null, trans('alert.invalid_callback_signature'), 403);
        }

        if ('payment_status' !== $request->header('X-Callback-Event')) {
            ResponseHelper::error(null, trans('alert.invalid_callback_event'), 403);
        }

        return $next($request);
    }
}
