<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScheduleRequest;
use App\Services\ScheduleService;
use Illuminate\Http\JsonResponse;

class ScheduleController extends Controller
{
    protected $scheduleService;

    public function __construct(ScheduleService $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }

    /**
     * Display all schedules
     */
    public function index(): JsonResponse
    {
        $schedules = $this->scheduleService->getAllSchedules();
        return response()->json($schedules);
    }

    /**
     * Get schedule by day
     */
    public function show($day): JsonResponse
    {
        $schedule = $this->scheduleService->getScheduleByDay($day);
        return response()->json($schedule);
    }

    /**
     * Update schedule for a specific day
     */
    public function update(ScheduleRequest $request, $day): JsonResponse
    {
        $schedule = $this->scheduleService->updateSchedule($day, $request->validated());
        return response()->json($schedule);
    }

    /**
     * Bulk update all schedules
     */
    public function bulkUpdate(ScheduleRequest $request): JsonResponse
    {
        $schedules = $this->scheduleService->bulkUpdateSchedules($request->validated());
        return response()->json($schedules);
    }
}
