<?php

namespace Raid\Core\Controller\Traits\Controller;

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
}