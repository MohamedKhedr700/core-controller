<?php

namespace Raid\Core\Controller\Traits\Controller;

trait WithResponse
{
    /**
     * Get a transformed resource.
     */
    protected function getTransformedResource(mixed $resource): array
    {
        return $this->fractalItem($resource, new (static::transformer()));
    }

    /**
     * Get a transformed collection.
     */
    protected function getTransformedResources(mixed $resources): array
    {
        return $this->fractalCollection($resources, new (static::transformer()));
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