<?php

namespace Pilulka\Api\Response;


class JsonResponse extends AbstractResponse
{

    protected $headers = [
        "Content-Type: application/json",
    ];

    public function render()
    {
        $this->renderHeaders();
        echo json_encode($this->data);
    }


}