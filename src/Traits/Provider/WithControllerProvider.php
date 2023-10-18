<?php

namespace Raid\Core\Controller\Traits\Provider;

trait WithControllerProvider
{
    /**
     * Register commands.
     */
    private function registerCommands(): void
    {
        $this->commands($this->commands);
    }
}
