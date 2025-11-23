<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Services\ContactService;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    protected $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    /**
     * Get contact information
     */
    public function show(): JsonResponse
    {
        $contact = $this->contactService->getContactInfo();
        return response()->json($contact);
    }

    /**
     * Update contact information
     */
    public function update(ContactRequest $request): JsonResponse
    {
        $contact = $this->contactService->updateContactInfo($request->validated());
        return response()->json($contact);
    }
}
