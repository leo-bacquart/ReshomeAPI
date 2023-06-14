<?php

namespace Hetic\ReshomeApi\Model\Manager;

use Hetic\ReshomeApi\Model\Bases\BaseManager;
use Hetic\ReshomeApi\Model\Class;

class PictureManager extends BaseManager
{
    public function getAnnouncePicturesById(int $announce_id) : array
    {
        $query = $this->db->prepare("SELECT * FROM Picture WHERE announce_id =:announceId");
        $query->bindValue(":announceId", $announce_id);
        $query->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, "Picture");

        return $query->fetchAll();
    }

    public function addPicture(Class\Picture $picture) : bool
    {
        $query = $this->db->prepare("INSERT INTO Picture (announce_id,picture_path) VALUES (:announceId, :picturePath)");
        $query->bindValue(":announceId", $picture->getAnnounceId());
        $query->bindValue(":picturePath", $picture->getPicturePath());

        return $query->execute();
    }

    public function updatePicturePath(Class\Picture $picture) : bool
    {
        $query = $this->db->prepare("UPDATE Picture SET picture_path = :picturePath WHERE picture_id = :pictureId");
        $query->bindValue(":pictureId", $picture->getPictureId());
        $query->bindValue(":picturePath", $picture->getPicturePath());

        return $query->execute();
    }

    public function deletePicture(Class\Picture $picture) : bool
    {
        $query = $this->db->prepare("DELETE FROM Picture WHERE picture_id = :pictureId");
        $query->bindValue(":pictureId", $picture->getPictureId());

        return $query->execute();
    }
}