<?php

namespace App\Services;

use App\Repositories\Contracts\ScheduleRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Exception;

class ScheduleService
{
    protected $scheduleRepository;

    public function __construct(ScheduleRepositoryInterface $scheduleRepository)
    {
        $this->scheduleRepository = $scheduleRepository;
    }

    /**
     * Get all schedules
     */
    public function getAllSchedules()
    {
        return $this->scheduleRepository->all();
    }

    /**
     * Get schedule by day
     */
    public function getScheduleByDay($day)
    {
        return $this->scheduleRepository->getByDay($day);
    }

    /**
     * Update schedule for a specific day
     */
    public function updateSchedule($day, array $data)
    {
        try {
            DB::beginTransaction();
            
            $schedule = $this->scheduleRepository->updateByDay($day, $data);
            
            DB::commit();
            return $schedule;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Bulk update schedules
     */
    public function bulkUpdateSchedules(array $schedules)
    {
        try {
            DB::beginTransaction();
            
            $updated = [];
            foreach ($schedules as $day => $data) {
                $updated[] = $this->scheduleRepository->updateByDay($day, $data);
            }
            
            DB::commit();
            return $updated;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
