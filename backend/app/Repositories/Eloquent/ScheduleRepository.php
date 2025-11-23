<?php

namespace App\Repositories\Eloquent;

use App\Models\Schedule;
use App\Repositories\Contracts\ScheduleRepositoryInterface;

class ScheduleRepository extends BaseRepository implements ScheduleRepositoryInterface
{
    public function __construct(Schedule $model)
    {
        parent::__construct($model);
    }

    public function getByDay($day)
    {
        return $this->model->where('day', $day)->first();
    }

    public function updateByDay($day, array $data)
    {
        $schedule = $this->getByDay($day);
        
        if ($schedule) {
            $schedule->update($data);
            return $schedule;
        }
        
        $data['day'] = $day;
        return $this->create($data);
    }
}
