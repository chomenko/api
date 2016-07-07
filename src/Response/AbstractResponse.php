<?php

namespace Pilulka\Api\Response;

abstract class AbstractResponse
{

    protected $data;
    protected $headers = [];

    /**
     * @param $data
     */
    public function __construct($data = [])
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function __toString()
    {
        ob_start();
        $this->render();
        $string = ob_get_clean();
        ob_end_flush();
        return $string;
    }

    abstract public function render();

    public function addHeader($header)
    {
        $this->headers[] = $header;
    }

    public function renderHeaders()
    {
        foreach ($this->headers as $header) {
            header($header);
        }
    }

}