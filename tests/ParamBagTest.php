<?php

require_once __DIR__ . "/../src/ParamBag.php";

class ParamBagTest extends PHPUnit_Framework_TestCase
{

    public function expectedDataProvider()
    {
        return json_decode(
            file_get_contents(__DIR__."/data/paramBagTestData.json"),
            true
        );
    }

    /**
     * @dataProvider expectedDataProvider
     */
    public function testProviderSet($input, $expected)
    {
        $bag = new \Pilulka\Api\ParamBag($input);
        if(array_key_exists('filter', $expected)) {
            $bag->setFilterFields($expected['filter']);
            $this->assertEquals($expected['filter'], $bag->getFilter());
        }
        if(array_key_exists('orderBy', $expected)) {
            $this->assertEquals($expected['orderBy'], $bag->getOrderBy());
        }
        if(array_key_exists('offset', $expected)) {
            $this->assertEquals($expected['offset'], $bag->getOffset());
        }
        if(array_key_exists('limit', $expected)) {
            $this->assertEquals($expected['limit'], $bag->getLimit());
        }
    }

}