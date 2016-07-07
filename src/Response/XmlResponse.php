<?php

namespace Pilulka\Api\Response;


class XmlResponse extends AbstractResponse
{
    private $rootElement;

    protected $headers = [
        "Content-Type: text/xml",
    ];

    public function render()
    {
        $this->renderHeaders();

        return $this->recursiveXml($this->data, new \SimpleXMLElement($this->getRootElement()));
    }

    public function setRootElement($element)
    {
        $this->rootElement = $element;
        return $this;
    }

    private function recursiveXml($array, \SimpleXMLElement &$xml, $elementName = null)
    {
        foreach ($array as $key => $value) {
            if(is_numeric($key)) {
                $child = $xml->addChild($elementName);
            } else {
                if($this->isAssoc($value)) {
                    $child = $xml->addChild($key);
                } else {
                    $child = $xml;
                }
            }

            if(!is_array($value)) {
                $xml->$key = $value;
            } else {
                $this->recursiveXml($value, $child, $key);
            }
        }

        return $xml->asXML();
    }

    private function getRootElement()
    {
        return "<?xml version=\"1.0\" encoding=\"UTF-8\"?><{$this->rootElement} />";
    }

    private function isAssoc($arr)
    {
        if(!is_array($arr)) return true;
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}