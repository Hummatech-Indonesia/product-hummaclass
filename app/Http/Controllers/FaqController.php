<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\FaqInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\FaqRequest;
use App\Http\Resources\FaqResource;
use App\Models\Faq;
use App\Traits\PaginationTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    use PaginationTrait;
    private FaqInterface $faq;
    public function __construct(FaqInterface $faq)
    {
        $this->faq = $faq;
    }
    /**
     * Method index
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $faqs = $this->faq->customPaginate($request);
        $data['paginate'] = $this->customPaginate($faqs->currentPage(), $faqs->lastPage());
        $data['data'] = FaqResource::collection($faqs);
        return ResponseHelper::success($data, trans('alert.fetch_success'));
    }

    /**
     * indexUser
     *
     * @return JsonResponse
     */
    public function indexUser(): JsonResponse
    {
        $faqs = $this->faq->get();
        return ResponseHelper::success(FaqResource::collection($faqs), trans('alert.fetch_success'));
    }
    /**
     * Method store
     *
     * @param FaqRequest $request [explicite description]
     *
     * @return JsonResponse
     */
    public function store(FaqRequest $request): JsonResponse
    {
        $this->faq->store($request->validated());
        return ResponseHelper::success(true, trans('alert.add_success'));
    }
    /**
     * Method show
     *
     * @param Faq $faq [explicite description]
     *
     * @return JsonResponse
     */
    public function show(Faq $faq): JsonResponse
    {
        $faq = $this->faq->show($faq->id);
        return ResponseHelper::success(FaqResource::make($faq), trans('alert.fetch_success'));
    }
    /**
     * Method update
     *
     * @param FaqRequest $request [explicite description]
     * @param Faq $faq [explicite description]
     *
     * @return JsonResponse
     */
    public function update(FaqRequest $request, Faq $faq): JsonResponse
    {
        $this->faq->update($faq->id, $request->validated());
        return ResponseHelper::success(true, trans('alert.update_success'));
    }
    /**
     * Method destroy
     *
     * @param Faq $faq [explicite description]
     *
     * @return JsonResponse
     */
    public function destroy(Faq $faq): JsonResponse
    {
        $this->faq->delete($faq->id);
        return ResponseHelper::success(true, trans('alert.delete_success'));
    }
}
