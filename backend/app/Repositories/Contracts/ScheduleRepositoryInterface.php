<?php

namespace App\Repositories\Contracts;

interface ScheduleRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get schedules by day
     */
    public function getByDay($day);

    /**
     * Update schedule for a specific day
     */
    public function updateByDay($day, array $data);
}
