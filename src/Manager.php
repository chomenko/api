<?php

namespace Pilulka\Api;

use Pilulka\Api\Response\AbstractResponse;
use Pilulka\Api\Response\JsonResponse;
use Pilulka\Api\Transformer\AbstractTransformer;

abstract class Manager
{

    protected $resourceTransformer;
    protected $inputTransformer;
    protected $paramBag;
    protected $responseData = [];
    /** @var Response\AbstractResponse  */
    protected $responseRender;

    /**
     * Manager constructor.
     * @param AbstractTransformer|null $resourceTransformer
     * @param ParamBag|null $paramBag
     */
    public function __construct(AbstractTransformer $resourceTransformer = null, ParamBag $paramBag = null)
    {
        $this->resourceTransformer = $resourceTransformer;
        $this->paramBag = (isset($paramBag)) ? $paramBag  : new ParamBag([]);
        $this->responseRender = new JsonResponse();
        $this->startup();
    }

    public function findOne($id)
    {
        $this->throwNotImplemented('create');
    }

    public function findMany(array $params)
    {
        $this->throwNotImplemented('create');
    }

    public function renderResponse()
    {
        $this->responseRender->setData($this->responseData);
        $this->responseRender->render();
    }

    public function create(array $input)
    {
        $this->throwNotImplemented('create');
    }

    public function update(array $input)
    {
        $this->throwNotImplemented('update');
    }

    public function patch(array $input)
    {
        $this->throwNotImplemented('patch');
    }

    public function delete($id)
    {
        $this->throwNotImplemented('delete');
    }

    /**
     * @param ParamBag $paramBag
     */
    public function setParamBag(ParamBag $paramBag)
    {
        $this->paramBag = $paramBag;
    }

    public function getResourceTransformer()
    {
        if(!isset($this->resourceTransformer)) {
            throw new ApiException("You must define resource transformer before it's use.");
        }
        return $this->resourceTransformer;
    }

    public function setResourceTransformer(AbstractTransformer $resourceTransformer)
    {
        $this->resourceTransformer = $resourceTransformer;
    }

    /**
     * @return AbstractTransformer
     * @throws ApiException
     */
    public function getInputTransformer()
    {
        if(!isset($this->inputTransformer)) {
            throw new ApiException("You must define input transformer before it's use.");
        }
        return $this->inputTransformer;
    }

    public function setInputTransformer(AbstractTransformer $inputTransformer)
    {
        $this->inputTransformer = $inputTransformer;
    }

    /**
     * @param Response\AbstractResponse $responseRender
     */
    public function setResponseRender(AbstractResponse $responseRender)
    {
        $this->responseRender = $responseRender;
    }

    protected function throwNotImplemented($method)
    {
        throw new ApiException("You have to implement `{$method} before use.`");
    }

    protected function startup()
    {
    }

    /**
     * @return array
     */
    public function getResponseData()
    {
        return $this->responseData;
    }



}