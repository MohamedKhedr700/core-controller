<?php

namespace Raid\Core\Controller\Traits\Response;

use Illuminate\Pagination\AbstractPaginator;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\TransformerAbstract;
use Raid\Core\Controller\Serializers\ArraySerializer;
use Spatie\Fractal\Facades\Fractal;
use Spatie\Fractalistic\Fractal as BaseFractal;

trait FractalBuilder
{
    /**
     * Transform fractal collection.
     */
    public function fractalCollection(mixed $collection, TransformerAbstract $transformer, array $includes = []): array
    {
        $fractalMethod = $collection instanceof AbstractPaginator ? 'fractalCollectionPaginated' : 'fractalCollectionNonPaginated';

        return $this->$fractalMethod($collection, $transformer, $includes);
    }

    /**
     * Transform fractal collection paginated.
     */
    public function fractalCollectionPaginated(mixed $collection, TransformerAbstract $transformer, array $includes = []): array
    {
        return $this->fractalCollectionBuilder($collection, $transformer, $includes)
            ->paginateWith(new IlluminatePaginatorAdapter($collection))
            ->toArray();
    }

    /**
     * Transform fractal collection non paginated.
     */
    public function fractalCollectionNonPaginated(mixed $collection, TransformerAbstract $transformer, array $includes = []): array
    {
        return $this->fractalCollectionBuilder($collection, $transformer, $includes)->toArray();
    }

    /**
     * Create base fractal collection instance.
     */
    private function fractalCollectionBuilder(mixed $collection, TransformerAbstract $transformer, array $includes = []): BaseFractal
    {
        return Fractal::create()
            ->collection($collection, $transformer)
            ->serializeWith(new ArraySerializer())
            ->parseIncludes($includes);
    }

    /**
     * Transform fractal item.
     */
    public function fractalItem(mixed $collection, TransformerAbstract $transformer, array $includes = []): array
    {
        return Fractal::create()
            ->item($collection, $transformer)
            ->serializeWith(new ArraySerializer())
            ->parseIncludes($includes)
            ->toArray();
    }
}
