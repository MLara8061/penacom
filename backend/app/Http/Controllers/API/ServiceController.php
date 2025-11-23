<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Services\ServiceService;
use Illuminate\Http\JsonResponse;

class ServiceController extends Controller
{
    protected $serviceService;

    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;
    }

    /**
     * Display a listing of services (Admin)
     */
    public function index(): JsonResponse
    {
        $services = $this->serviceService->getAllServices();
        return response()->json($services);
    }

    /**
     * Display active services (Public)
     */
    public function active(): JsonResponse
    {
        $services = $this->serviceService->getActiveServices();
        return response()->json($services);
    }

    /**
     * Display the specified service
     */
    public function show($id): JsonResponse
    {
        $service = $this->serviceService->getService($id);
        return response()->json($service);
    }

    /**
     * Store a newly created service
     */
    public function store(ServiceRequest $request): JsonResponse
    {
        $service = $this->serviceService->createService($request->validated());
        return response()->json($service, 201);
    }

    /**
     * Update the specified service
     */
    public function update(ServiceRequest $request, $id): JsonResponse
    {
        $service = $this->serviceService->updateService($id, $request->validated());
        return response()->json($service);
    }

    /**
     * Remove the specified service
     */
    public function destroy($id): JsonResponse
    {
        $this->serviceService->deleteService($id);
        return response()->json(['message' => 'Service deleted successfully']);
    }

    /**
     * Toggle service status
     */
    public function toggleStatus($id): JsonResponse
    {
        $service = $this->serviceService->toggleServiceStatus($id);
        return response()->json($service);
    }
}
