<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\HeaderInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\HeaderRequest;
use App\Http\Resources\HeaderResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HeaderController extends Controller
{
    private HeaderInterface $header;

    public function __construct(HeaderInterface $header)
    {
        $this->header = $header;
    }


    /**
     * index
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $header = $this->header->get();
        return ResponseHelper::success(HeaderResource::make($header));
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function store(HeaderRequest $request): JsonResponse
    {
        $this->header->store($request->validated());
        return ResponseHelper::success(null, trans('alert.update_success'));
    }
}
