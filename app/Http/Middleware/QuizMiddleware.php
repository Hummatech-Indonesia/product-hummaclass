<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseHelper;
use App\Models\Module;
use App\Models\SubModule;
use App\Models\UserCourse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class QuizMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $slug_module = $request->route('slug');

        $module = Module::query()->where('slug', $slug_module)->firstOrFail();

        $subModule = SubModule::query()->where('module_id', $module->id)->orderBy('step', 'desc')->firstOrFail();
        $lasStep = $subModule->step;
        $userCourse = UserCourse::query()->where('user_id', auth()->user()->id)->where('course_id', $module->course_id)->firstOrFail();
        if ($userCourse->subModule->module->step > $module->step && $userCourse->subModule->step == $lasStep) {
            return ResponseHelper::error(null, "Selesaikan Materi Sebelumnya", 403);
        }
        return $next($request);
    }
}
