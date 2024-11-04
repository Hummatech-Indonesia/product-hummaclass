<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\Configuration\ContactInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\ContactRequest;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    private ContactInterface $contact;
    public function __construct(ContactInterface $contact)
    {
        $this->contact = $contact;
    }
    /**
     * Method index
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $contact = $this->contact->get();
        return ResponseHelper::success($contact, trans('alert.fetch_success'));
    }

    /**
     * post
     *
     * @param  mixed $request
     * @param  mixed $contact
     * @return JsonResponse
     */
    public function post(ContactRequest $request): JsonResponse
    {
        $this->contact->store($request->validated());
        return ResponseHelper::success(true, trans('alert.update_success'));
    }

    /**
     * show
     *
     * @param  mixed $contact
     * @return JsonResponse
     */
    public function show(): JsonResponse
    {
        $contact = $this->contact->show(1);
        return ResponseHelper::success(ContactResource::make($contact));
    }
}
