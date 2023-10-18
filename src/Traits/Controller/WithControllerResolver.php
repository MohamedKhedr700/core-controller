<?php

namespace Raid\Core\Modules\Traits\Controller;

use League\Fractal\TransformerAbstract;

trait WithControllerResolver
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
     * Get module name.
     */
    public static function getModule()
    {
        return static::repository()::getModule();
    }

    /**
     * Get transformer.
     */
    protected function getTransformer(): TransformerAbstract
    {
        $transformerClass = static::repository()::getTransformer();

        return new ($transformerClass);
    }

    /**
     * Get localized module.
     */
    protected function getLocalizedModule(): string
    {
        $module = static::getModule();

        return trans("{$module}::{$module}.{$module}");
    }

    /**
     * Get a response message.
     */
    protected function getResponseMessage(string $action, string $status = 'success'): string
    {
        return trans("messages.$action.$status", [
            'module' => $this->getLocalizedModule(),
        ]);
    }
}