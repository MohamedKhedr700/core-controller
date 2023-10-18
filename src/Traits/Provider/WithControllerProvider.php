<?php

namespace Raid\Core\Modules\Traits\Provider;

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
