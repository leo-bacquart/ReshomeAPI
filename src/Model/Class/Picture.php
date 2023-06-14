<?php

namespace Hetic\ReshomeH\Model\Class;

class Picture extends \Hetic\ReshomeH\Model\Bases\BaseClass
{
    private int $picture_id;
    private int $announce_id;
    private string $picture_path;

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
}