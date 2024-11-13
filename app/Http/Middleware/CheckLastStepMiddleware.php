<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseHelper;
use App\Helpers\SubModuleHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLastStepMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        dd(auth()->user());
        if (auth()->user()->hasRole('admin')) {
            return $next($request);
        }
        $slug_sub_module = $request->route('slug');
        $helper = SubModuleHelper::sub_module($slug_sub_module);
        if ($helper) return $next($request);
        return ResponseHelper::error(null, "Selesaikan Materi Sebelumnya", 403);
    }
}
