<?php

namespace Hetic\ReshomeApi\Model\Manager;

use Hetic\ReshomeApi\Model\Bases\BaseManager;
use Hetic\ReshomeApi\Model\Entity;

class PictureManager extends BaseManager
{
    public function getPicturesByAnnounceId(int $announceId) : array
    {
        $query = 'SELECT * FROM Picture WHERE announce_id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, Entity\Picture::class);
        $stmt->execute(['id' => $announceId]);
        return $stmt->fetchAll();
    }

    public function addPicture(int $announce_id, string $picturePath) : bool
    {
        $query = $this->db->prepare("INSERT INTO Picture (announce_id,picture_path) VALUES (:announceId, :picturePath)");
        $query->bindValue(":announceId", $announce_id);
        $query->bindValue(":picturePath", $picturePath);

        return $query->execute();
    }

    public function updatePicturePath(Entity\Picture $picture) : bool
    {
        $query = $this->db->prepare("UPDATE Picture SET picture_path = :picturePath WHERE picture_id = :pictureId");
        $query->bindValue(":pictureId", $picture->getPictureId());
        $query->bindValue(":picturePath", $picture->getPicturePath());

        return $query->execute();
    }

    public function deletePicture(Entity\Picture $picture) : bool
    {
        $query = $this->db->prepare("DELETE FROM Picture WHERE picture_id = :pictureId");
        $query->bindValue(":pictureId", $picture->getPictureId());

        return $query->execute();
    }
}