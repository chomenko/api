<?php

namespace Pilulka\Api\Tranformer;

use Pilulka\Api\ApiException;

abstract class AbstractTransformer
{
    /**
     * @param $entity
     * @throws ApiException
     * @return array
     */
    public function transform($entity) {
        throw new ApiException(
            "Override this method to implement your own transformer method."
        );
    }

}
