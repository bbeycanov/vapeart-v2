<?php

namespace App\Services;

use App\Models\ContactMessage;
use App\Services\Contracts\ContactMessageServiceInterface;
use App\Repositories\Contracts\ContactMessageRepositoryInterface;

class ContactMessageService extends AbstractService implements ContactMessageServiceInterface
{
    /**
     * @param ContactMessageRepositoryInterface $repo
     * @param ContactMessage $model
     */
    public function __construct(
        private readonly ContactMessageRepositoryInterface $repo,
        ContactMessage $model
    )
    {
        parent::__construct($model);
        $this->cachePrefix('svc:contact-message:');
    }

    /**
     * @param array $data
     * @return ContactMessage
     */
    public function create(array $data): ContactMessage
    {
        return $this->repo->create($data);
    }
}

