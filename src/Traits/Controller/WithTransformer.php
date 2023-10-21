<?php

namespace Raid\Core\Controller\Traits\Controller;

use Raid\Core\Controller\Transformers\Contracts\TransformerInterface;

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
     * Get Transformer instance.
     */
    public function getTransformer(): TransformerInterface
    {
        return new (static::transformer());
    }
}