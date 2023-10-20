<?php

namespace Raid\Core\Controller\Traits\Controller;

trait WithMessage
{
    /**
     * Get module name.
     */
    public static function getModule()
    {
        return static::repository()::getModule();
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