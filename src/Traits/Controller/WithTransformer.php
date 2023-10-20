<?php

namespace Raid\Core\Controller\Traits\Controller;

trait WithTransformer
{
    /**
     * Transformer class.
     */
    public const TRANSFORMER = '';

    /**
     * Get Transformer class.
     */
    public static function transformer(): string
    {
        return static::TRANSFORMER;
    }
}