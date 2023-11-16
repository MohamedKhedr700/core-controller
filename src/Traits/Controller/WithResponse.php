<?php

namespace Raid\Core\Controller\Traits\Controller;

trait WithResponse
{
    /**
     * Get a transformed resource.
     */
    protected function transformResource(mixed $resource): ?array
    {
        if (is_null($resource)) {
            return null;
        }

        return $this->fractalItem($resource, $this->getTransformer());
    }

    /**
     * Get a transformed collection.
     */
    protected function transformResources(mixed $resources): ?array
    {
        if (is_null($resources)) {
            return null;
        }

        return $this->fractalCollection($resources, $this->getTransformer());
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