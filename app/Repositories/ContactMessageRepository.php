<?php

namespace App\Repositories;

use App\Models\ContactMessage;
use Psr\SimpleCache\InvalidArgumentException;
use App\Repositories\Contracts\ContactMessageRepositoryInterface;

class ContactMessageRepository extends BaseRepository implements ContactMessageRepositoryInterface
{
    /**
     * @return string
     */
    public static function modelClass(): string
    {
        return ContactMessage::class;
    }

    /**
     * @param ContactMessage $model
     */
    public function __construct(ContactMessage $model)
    {
        parent::__construct($model);
    }

    /**
     * @param array $data
     * @return ContactMessage
     * @throws InvalidArgumentException
     */
    public function create(array $data): ContactMessage
    {
        /** @var ContactMessage $model */
        $model = parent::create($data);
        return $model;
    }
}

