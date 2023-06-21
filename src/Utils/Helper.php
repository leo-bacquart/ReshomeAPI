<?php

namespace Hetic\ReshomeApi\Utils;

use Hetic\ReshomeApi\Model\Entity\Announce;
use http\Exception\RuntimeException;

class Helper
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

    public static function moveImages($pictures) : mixed
    {
        $picCount = count($pictures['name']);

        $picCount <= 3 ? $iteration = $picCount : $iteration = 3;

        $newFileNames = [];

        for ($i = 0; $i < $iteration; $i++) {

            // Security, Error handlers
            if ($pictures['error'][$i] != UPLOAD_ERR_OK) {
                return 'Error : Error in upload';
            }
            if ($pictures['size'][$i] > 1000000000000000) {
                return 'Error : Image size is too much';
            }
            if ($pictures['type'][$i] != 'image/jpeg' && $pictures['type'][$i] != 'image/jpg' && $pictures['type'][$i] != 'image/png') {
                return 'Error : Incorrect file type';
            }

            $tmpPictureDir = $pictures['tmp_name'][$i];
            $newFileName = uniqid() . '-' . $pictures['name'][$i];
            $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/images/' . $newFileName;
            if (move_uploaded_file($tmpPictureDir, $targetDir)) {
                $newFileNames[] = $newFileName;
            } else {
                return 'Error : Impossible to move file';
            }

        }
        return $newFileNames;
    }

}