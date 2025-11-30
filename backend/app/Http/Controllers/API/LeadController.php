<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LeadRequest;
use App\Models\Lead;
use Illuminate\Http\JsonResponse;

class LeadController extends Controller {
    /**
     * Display a listing of leads (admin only)
     */
    public function index(): JsonResponse {
        $leads = Lead::orderBy('created_at', 'desc')->get();
        return response()->json($leads);
    }

    /**
     * Store a new lead from contact form (public)
     */
    public function store(LeadRequest $request): JsonResponse {
        $lead = Lead::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => '¡Gracias! Tu solicitud ha sido enviada. Te contactaremos pronto.',
            'data' => $lead
        ], 201);
    }

    /**
     * Display the specified lead
     */
    public function show(Lead $lead): JsonResponse {
        return response()->json($lead);
    }

    /**
     * Update the specified lead (status change)
     */
    public function update(LeadRequest $request, Lead $lead): JsonResponse {
        $lead->update($request->validated());
        return response()->json($lead);
    }

    /**
     * Remove the specified lead
     */
    public function destroy(Lead $lead): JsonResponse {
        $lead->delete();
        return response()->json(['message' => 'Lead eliminado exitosamente']);
    }
}
