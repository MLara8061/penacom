<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Services\ContactService;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller {
    protected $contactService;

    public function __construct(ContactService $contactService) {
        $this->contactService = $contactService;
    }

    /**
     * Get all contact messages (leads)
     */
    public function index(): JsonResponse {
        $contacts = Contact::orderBy('created_at', 'desc')->get();
        return response()->json($contacts);
    }

    /**
     * Store a new contact message (lead from landing page)
     */
    public function store(ContactRequest $request): JsonResponse {
        $contact = Contact::create($request->validated());
        return response()->json([
            'message' => 'Mensaje enviado exitosamente',
            'data' => $contact
        ], 201);
    }

    /**
     * Get contact information
     */
    public function show(): JsonResponse {
        $contact = $this->contactService->getContactInfo();
        return response()->json($contact);
    }

    /**
     * Update contact information
     */
    public function update(ContactRequest $request): JsonResponse {
        $contact = $this->contactService->updateContactInfo($request->validated());
        return response()->json($contact);
    }
}
