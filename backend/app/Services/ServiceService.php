<?php

namespace App\Services;

use App\Repositories\Contracts\ServiceRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Exception;

class ServiceService
{
    protected $serviceRepository;

    public function __construct(ServiceRepositoryInterface $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    /**
     * Get all services
     */
    public function getAllServices()
    {
        return $this->serviceRepository->all();
    }

    /**
     * Get active services for public view
     */
    public function getActiveServices()
    {
        return $this->serviceRepository->getActive();
    }

    /**
     * Get a single service
     */
    public function getService($id)
    {
        return $this->serviceRepository->find($id);
    }

    /**
     * Create a new service
     */
    public function createService(array $data)
    {
        try {
            DB::beginTransaction();
            
            $service = $this->serviceRepository->create($data);
            
            DB::commit();
            return $service;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update an existing service
     */
    public function updateService($id, array $data)
    {
        try {
            DB::beginTransaction();
            
            $service = $this->serviceRepository->update($id, $data);
            
            DB::commit();
            return $service;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Delete a service
     */
    public function deleteService($id)
    {
        try {
            DB::beginTransaction();
            
            $this->serviceRepository->delete($id);
            
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Toggle service status
     */
    public function toggleServiceStatus($id)
    {
        $service = $this->getService($id);
        return $this->serviceRepository->updateStatus($id, !$service->is_active);
    }
}
