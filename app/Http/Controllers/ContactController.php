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
     * Method show
     *
     * @return JsonResponse
     */
    public function show(): JsonResponse
    {
        return ResponseHelper::success(ContactResource::make($this->contact->show()), trans('alert.fetch_success'));
    }
    /**
     * Method update
     *
     * @param ContactRequest $request [explicite description]
     *
     * @return JsonResponse
     */
    public function update(ContactRequest $request): JsonResponse
    {
        $this->contact->update($request->validated());
        return ResponseHelper::success(null, trans('alert.update_success'));
    }
}
