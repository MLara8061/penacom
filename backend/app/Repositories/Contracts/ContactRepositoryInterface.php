<?php

namespace App\Repositories\Contracts;

interface ContactRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get contact information
     */
    public function getContactInfo();

    /**
     * Update contact information
     */
    public function updateContactInfo(array $data);
}
