<?php

namespace Hetic\ReshomeApi\Model\Entity;
use Hetic\ReshomeApi\Model\Bases\BaseClass;

class AnnounceFeature extends BaseClass
{
    private int $announce_id;
    private int $feature_id;

    public function getAnnounceId(): int
    {
        return $this->announce_id;
    }

    public function setAnnounceId($announce_id): void
    {
        $this->announce_id = $announce_id;
    }

    public function getFeatureId(): int
    {
        return $this->feature_id;
    }

    public function setFeatureId($feature_id): void
    {
        $this->feature_id = $feature_id;
    }

    public static function create($data)
    {
    }

    public static function find($announce_id, $feature_id)
    {
    }

    public function update()
    {
    }

    public function delete()
    {
    }
}
