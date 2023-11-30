<?php

namespace Raid\Core\Controller\Traits\Controller;

trait WithResponse
{
    /**
     * Get a transformed resource.
     */
    protected function transformResource(mixed $resource, array $includes = []): ?array
    {
        return is_null($resource) ? null :$this->fractalItem($resource, $this->getTransformer(), $includes);
    }

    /**
     * Get a transformed collection.
     */
    protected function transformResources(mixed $resources, array $includes = []): ?array
    {
        return is_null($resources) ? null :$this->fractalCollection($resources, $this->getTransformer(), $includes);
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