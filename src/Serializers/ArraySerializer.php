<?php

namespace Raid\Core\Controller\Serializers;

use League\Fractal\Pagination\CursorInterface;
use League\Fractal\Pagination\PaginatorInterface;
use League\Fractal\Resource\ResourceInterface;
use League\Fractal\Serializer\SerializerAbstract;

class ArraySerializer extends SerializerAbstract
{
    /**
     * Serialize a collection.
     *
     * @param  string  $resourceKey
     */
    public function collection($resourceKey, array $data): array
    {
        return ($resourceKey !== false) ? [$resourceKey ?: 'data' => $data] : $data;
    }

    /**
     * Serialize an item.
     *
     * @param  string  $resourceKey
     */
    public function item($resourceKey, array $data): array
    {
        return $data;
    }

    /**
     * Serialize null resource.
     */
    public function null(): array
    {
        return [];
    }

    /**
     * Serialize the included data.
     */
    public function includedData(ResourceInterface $resource, array $data): array
    {
        return $data;
    }

    /**
     * Serialize the meta.
     */
    public function meta(array $meta): array
    {
        if (empty($meta)) {
            return [];
        }

        return ['meta' => $meta];
    }

    /**
     * Serialize the paginator.
     */
    public function paginator(PaginatorInterface $paginator): array
    {
        $currentPage = (int) $paginator->getCurrentPage();
        $lastPage = (int) $paginator->getLastPage();

        $pagination = [
            'current_page' => $currentPage,
            'first_page' => 1,
            'last_page' => $lastPage,
            'per_page' => (int) $paginator->getPerPage(),
            'count' => (int) $paginator->getCount(),
            'total_records' => (int) $paginator->getTotal(),
        ];

        $pagination['links'] = [];
        $pagination['links']['first'] = $paginator->getUrl(1);
        $pagination['links']['last'] = $paginator->getUrl($lastPage);
        $pagination['links']['previous'] = null;
        $pagination['links']['next'] = null;

        if ($currentPage > 1) {
            $pagination['links']['previous'] = $paginator->getUrl($currentPage - 1);
        }

        if ($currentPage < $lastPage) {
            $pagination['links']['next'] = $paginator->getUrl($currentPage + 1);
        }

        if (empty($pagination['links'])) {
            $pagination['links'] = (object) [];
        }

        return ['pagination' => $pagination];
    }

    /**
     * Serialize the cursor.
     */
    public function cursor(CursorInterface $cursor): array
    {
        $cursor = [
            'current' => $cursor->getCurrent(),
            'prev' => $cursor->getPrev(),
            'next' => $cursor->getNext(),
            'count' => (int) $cursor->getCount(),
        ];

        return ['cursor' => $cursor];
    }
}
