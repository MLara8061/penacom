<?php

namespace App\Repositories\Eloquent;

use App\Models\Contact;
use App\Repositories\Contracts\ContactRepositoryInterface;

class ContactRepository extends BaseRepository implements ContactRepositoryInterface
{
    public function __construct(Contact $model)
    {
        parent::__construct($model);
    }

    public function getContactInfo()
    {
        return $this->model->first();
    }

    public function updateContactInfo(array $data)
    {
        $contact = $this->getContactInfo();
        
        if ($contact) {
            $contact->update($data);
            return $contact;
        }
        
        return $this->create($data);
    }
}
