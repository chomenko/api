<?php

namespace Pilulka\Api;

/**
 * Class ParamBag
 * @package Pilulka\Api
 * @method array getFilter()
 * @method int getLimit()
 * @method int getOffset()
 * @method array|string getOrderBy()
 */
class ParamBag
{

    private $innerFields = [
        'limit',
        'offset',
        'orderBy',
    ];

    private $params = [];
    private $limit = 100;
    private $offset = 0;
    private $filter = [];
    private $orderBy;
    private $filterFields = ['']; // non empty - todo: predelat
    private $fixedFilter = [];
    private $initialized = false;

    public function __construct(array $params = [])
    {
        $this->params = $params;
    }

    public function setParams(array $params)
    {
        $this->params = $params;
    }

    public function setFixedFilter(array $fixedFilter)
    {
        $this->fixedFilter = $fixedFilter;
    }

    public function setFilterFields(array $filterFields)
    {
        if ($this->initialized) {
            throw new \RuntimeException("Define filter fields before param bag use.");
        }
        $this->filterFields = $filterFields;
    }

    public function setOrderBy($orderBy)
    {
        $this->orderBy = $orderBy;
    }

    public function __call($name, $args = [])
    {
//        if (!$this->initialized) {
            $this->initialize();
//        }
        if (strpos($name, 'get') == 0) {
            $name = lcfirst(ltrim($name, 'get'));
            if (method_exists($this, $name)) {
                return call_user_func_array([$this, $name], $args);
            }
        }
        throw new \RuntimeException("Calling of invalid class method: `{$name}``");
    }


    protected function limit()
    {
        return $this->limit;
    }

    protected function offset()
    {
        return $this->offset;
    }

    protected function filter()
    {
        return $this->filter;
    }

    protected function orderBy()
    {
        return $this->orderBy;
    }

    private function initialize()
    {
        $this->initialized = true;
        $this->mergeFilterFields();
        $this->mergeLimit();
        $this->mergeOffset();
        $this->mergeOrderBy();
    }


    private function mergeFilterFields()
    {
        $this->filter = [];
        foreach ($this->params as $key=>$val) {
            if(array_key_exists($key, $this->innerFields)) {
                continue;
            }
            if(count($this->filterFields) && in_array($key, $this->filterFields)) {
                $this->filter[$key] = $val;
            } elseif(!count($this->filterFields)) {
                $this->filter[$key] = $val;
            }
        }
        $this->filter = $this->fixedFilter + $this->filter;
    }

    private function mergeLimit()
    {
        if(array_key_exists('limit', $this->params)) {
            $this->limit = (int)$this->params['limit'];
        }
    }

    private function mergeOffset()
    {
        if(array_key_exists('offset', $this->params)) {
            $this->offset = (int)$this->params['offset'];
        }
    }

    private function mergeOrderBy()
    {
        if(array_key_exists('orderBy', $this->params)) {
            if(strpos($this->params['orderBy'], '|')) {
                $parts = explode('|', trim($this->params['orderBy'], '|'));
                $items = [];
                foreach ($parts as $part) {
                    $items[] = $this->parseOrderBy($part);
                }
                if(count($items)) {
                    $this->orderBy = $items;
                }
            } else {
                $this->orderBy = $this->parseOrderBy($this->params['orderBy']);
            }
        }
    }

    private function parseOrderBy($orderBy)
    {
        return str_replace(':', ' ', $orderBy);
    }

}