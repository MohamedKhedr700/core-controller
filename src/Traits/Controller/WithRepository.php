<?php

namespace Raid\Core\Controller\Traits\Controller;

use Raid\Core\Repository\Repositories\Contracts\RepositoryInterface;

trait WithRepository
{
    /**
     * Repository class.
     */
    public const REPOSITORY = '';

    /**
     * Get repository class.
     */
    public static function repository(): string
    {
        return static::REPOSITORY;
    }

    /**
     * Get repository instance.
     */
    public function getRepository(): RepositoryInterface
    {
        return new (static::repository());
    }
}