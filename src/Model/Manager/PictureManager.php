<?php

namespace Hetic\ReshomeApi\Model\Manager;

use Hetic\ReshomeApi\Model\Bases\BaseManager;
use Hetic\ReshomeApi\Model\Entity;

class PictureManager extends BaseManager
{
    public function getAnnouncePicturesById(int $announce_id) : array
    {
        $query = $this->db->prepare("SELECT * FROM Picture WHERE announce_id =:announceId");
        $query->bindValue(":announceId", $announce_id);
        $query->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, "Picture");

        return $query->fetchAll();
    }

    public function addPicture(int $announce_id, $picture) : bool
    {
        $query = $this->db->prepare("INSERT INTO Picture (announce_id,picture_path) VALUES (:announceId, :picturePath)");
        $query->bindValue(":announceId", $picture->getAnnounceId());
        $query->bindValue(":picturePath", $picture->getPicturePath());

        return $query->execute();
    }

    public function uploadPicture($pictures) : mixed
    {
        $picCount = count($pictures['name']);

        $picCount <= 3 ? $iteration = $picCount : $iteration = 3;

        for ($i = 0; $i < $iteration; $i++) {
            if ($pictures['error'][$i] != UPLOAD_ERR_OK) {
                return 'Error : Error in upload';
            }
            if ($pictures['size'][$i] > 4000) {
                return 'Error : Image size is too much';
            }
            if ($pictures['type'][$i] != 'image/jpeg' || $pictures['type'][$i] != 'image/jpg' || $pictures['type'][$i] != 'image/png') {
                return 'Error : Incorrect file type';
            }

            $tmpPictureDir = $pictures['tmp_name'][$i];
            $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/public/images';
            $newFileName = uniqid() . '-' . $pictures['name'][$i];

            if (move_uploaded_file($tmpPictureDir, $targetDir)) {
                return $newFileName;
            }

            return 'Error : Impossible to move file';
        }

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