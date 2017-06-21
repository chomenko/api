<?php

namespace Pilulka\Api\Transformer;


class ArrayTransformer extends AbstractTransformer
{

    public function transform($entity)
    {
        return (array) $entity;
    }

}