<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\Configuration\ContactInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\ContactRequest;
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
     * Method update
     *
     * @param ContactRequest $request [explicite description]
     * @param Contact $contact [explicite description]
     *
     * @return JsonResponse
     */
    public function update(ContactRequest $request, Contact $contact): JsonResponse
    {
        $this->contact->update($contact->id, $request->validated());
        return ResponseHelper::success(true, trans('alert.update_success'));
    }

}
