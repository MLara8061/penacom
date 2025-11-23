<?php

namespace App\Services;

use App\Repositories\Contracts\ContactRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Exception;

class ContactService
{
    protected $contactRepository;

    public function __construct(ContactRepositoryInterface $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    /**
     * Get contact information
     */
    public function getContactInfo()
    {
        return $this->contactRepository->getContactInfo();
    }

    /**
     * Update contact information
     */
    public function updateContactInfo(array $data)
    {
        try {
            DB::beginTransaction();
            
            $contact = $this->contactRepository->updateContactInfo($data);
            
            DB::commit();
            return $contact;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
