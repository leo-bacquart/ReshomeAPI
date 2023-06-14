<?php

namespace Hetic\ReshomeApi\Utils;

use http\Exception\RuntimeException;

class Utils
{
    public static function getAverageFromObject(array $objects, string $attribute): mixed
    {
        $values = [];
        $method = 'get' . ucfirst($attribute);
        foreach ($objects as $object) {
            if (!is_callable([$object, $method])) {
                throw new RuntimeException($method . 'is not callable');
            }
            $values[] = $object->$method();
        }
        if (count($values) === 0) {
            return false;
        }
        return round(array_sum($values) / count($values), 2);
    }
}