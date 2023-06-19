<?php

namespace Hetic\ReshomeApi\Model\Bases;

abstract class BaseClass implements \JsonSerializable
{
    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}