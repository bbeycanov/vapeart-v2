<?php

namespace App\Repositories\Contracts;

use App\Models\ContactMessage;

interface ContactMessageRepositoryInterface extends RepositoryInterface
{
    /**
     * @param array $data
     * @return ContactMessage
     */
    public function create(array $data): ContactMessage;
}

