<?php

namespace Raid\Core\Controller\Traits\Controller;

use League\Fractal\TransformerAbstract;

trait WithTransformer
{
    /**
     * Transformer class.
     */
    public const TRANSFORMER = null;

    /**
     * Get Transformer class.
     */
    public static function transformer(): string
    {
        return static::TRANSFORMER;
    }

    /**
     * Get repository transformer instance.
     */
    public static function getRepositoryTransformer(): string
    {
        return static::repository()::getTransformer();
    }

    /**
     * Get Transformer instance.
     */
    public function getTransformer(): TransformerAbstract
    {
        $transformer = static::transformer() ?: static::getRepositoryTransformer();

        return new $transformer;
    }
}