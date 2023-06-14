<?php

namespace Hetic\ReshomeH\Model\Manager;

use Hetic\ReshomeH\Model\Bases\BaseManager;
use Hetic\ReshomeH\Model\Class\Picture;

class PictureManager extends BaseManager
{
    public function getAnnouncePicturesById(int $announce_id) : Picture
    {
        $query = $this->db->prepare("SELECT * FROM Picture WHERE announce_id =:announceId");
        $query->bindValue(":announceId", $announce_id);
        $query->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, "Picture");

        return $query->fetchAll();
    }

    public function addPicture(Picture $picture) : bool
    {
        $query = $this->db->prepare("INSERT INTO Picture (announce_id,picture_path,) VALUES (:announceId, :picturePath)");
        $query->bindValue(":announceId", $picture->getAnnounceId());
        $query->bindValue(":picturePath", $picture->getPicturePath());

        return $query->execute();
    }

    public function updatePicturePath(Picture $picture) : bool
    {
        $query = $this->db->prepare("UPDATE Picture SET picture_path = :picturePath WHERE id = :pictureId");
        $query->bindValue(":pictureId", $picture->getPictureId());
        $query->bindValue(":picturePath", $picture->getPicturePath());

        return $query->execute();
    }

    public function deletePicture(Picture $picture) : bool
    {
        $query = $this->db->prepare("DELETE * FROM Picture WHERE id = :pictureId");
        $query->bindValue(":pictureId", $picture->getPictureId());

        return $query->execute();
    }
}