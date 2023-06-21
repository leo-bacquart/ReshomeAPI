<?php

namespace Hetic\ReshomeApi\Model\Entity;
use Hetic\ReshomeApi\Model\Bases\BaseClass;

class Picture extends BaseClass implements \JsonSerializable
{
    protected int $picture_id;
    protected int $announce_id;
    protected string $picture_path;

    /**
     * @return int
     */
    public function getPictureId(): int
    {
        return $this->picture_id;
    }

    /**
     * @param int $picture_id
     */
    public function setPictureId(int $picture_id): void
    {
        $this->picture_id = $picture_id;
    }

    /**
     * @return int
     */
    public function getAnnounceId(): int
    {
        return $this->announce_id;
    }

    /**
     * @param int $announce_id
     */
    public function setAnnounceId(int $announce_id): void
    {
        $this->announce_id = $announce_id;
    }

    /**
     * @return string
     */
    public function getPicturePath(): string
    {
        return $this->picture_path;
    }

    /**
     * @param string $picture_path
     */
    public function setPicturePath(string $picture_path): void
    {
        $this->picture_path = $picture_path;
    }

    public function jsonSerialize(): mixed
    {
        return (object) get_object_vars($this);
    }
}