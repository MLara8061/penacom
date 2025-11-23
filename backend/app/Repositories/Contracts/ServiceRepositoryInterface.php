<?php

namespace App\Repositories\Contracts;

interface ServiceRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get active services
     */
    public function getActive();

    /**
     * Update service status
     */
    public function updateStatus($id, bool $status);
}
