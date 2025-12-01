<?php

namespace App\Services\Contracts;

use App\Models\ContactMessage;

interface ContactMessageServiceInterface
{
    /**
     * @param array $data
     * @return ContactMessage
     */
    public function create(array $data): ContactMessage;
}

