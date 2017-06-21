<?php

namespace Pilulka\Api\Transformer;

class CollectionTransformer extends AbstractTransformer
{

    protected $entityTransformer;

    /**
     * CollectionTransformer constructor.
     * @param $entityTransformer
     */
    public function __construct(AbstractTransformer $entityTransformer)
    {
        $this->entityTransformer = $entityTransformer;
    }

    public function transform($entities)
    {
        $items = [];
        foreach ($entities as $entity) {
            $items[] = $this->entityTransformer->transform($entity);
        }
        return $items;
    }

}