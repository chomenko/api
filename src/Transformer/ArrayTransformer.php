<?php

namespace Pilulka\Api\Tranformer;


class ArrayTransformer extends AbstractTransformer
{

    public function transform($entity)
    {
        return (array) $entity;
    }

}