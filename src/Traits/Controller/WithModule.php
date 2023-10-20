<?php

namespace Raid\Core\Controller\Traits\Controller;

trait WithModule
{
    /**
     * Get module name.
     */
    public static function getModule()
    {
        return static::repository()::utility()::moduleLower();
    }

    /**
     * Get localized module.
     */
    protected function getLocalizedModule(): string
    {
        $module = static::getModule();

        return trans("{$module}::{$module}.{$module}");
    }
}