<?php

namespace Pilulka\Api\Resource;


use Pilulka\Api\Transformer;

abstract class AbstractResource
{

    /** @var \ArrayIterator  */
    protected $entity;
    /** @var Transformer  */
    protected $transformer;

    /**
     * @param mixed $entity
     * @param Transformer|null $transformer
     */
    public function __construct($entity = null, Transformer $transformer = null)
    {
        $this->entity = $entity;
        $this->transformer = $transformer;
    }

    /**
     * @return \ArrayIterator
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param \ArrayIterator $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return Transformer
     */
    public function getTransformer()
    {
        return $this->transformer;
    }

    /**
     * @param Transformer $transformer
     */
    public function setTransformer($transformer)
    {
        $this->transformer = $transformer;
    }

    public function getData()
    {
        return $this->transformer->transform($this->entity);
    }

}