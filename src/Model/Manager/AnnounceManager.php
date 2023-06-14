<?php

namespace Hetic\ReshomeH\Model\Manager;

use Hetic\ReshomeH\Model\Bases\BaseManager;
use Hetic\ReshomeH\Model\Class;

class AnnounceManager extends BaseManager
{
    public function addAnnounce(Announce $announce)
    {
        $query = $this->db->prepare("INSERT INTO Announce (title, description, neighborhood, arrondissement, bedroom_number, capacity, `type`, area) VALUES (:title, :description, :neighborhood, :arrondissement, :bedromm_number, :capacity, :`type`, :area, :price)");

        $query->bindValue(":title", $announce->getTitle());
        $query->bindValue(":description", $announce->getDescription());
        $query->bindValue(":neighborhood", $announce->getNeighborhood());
        $query->bindValue(":arrondissement", $announce->getArrondissement());
        $query->bindValue(":bedroom_number", $announce->getBedroomNumber());
        $query->bindValue(":capacity", $announce->getCapacity());
        $query->bindValue(":type", $announce->getType());
        $query->bindValue(":area", $announce->getArea());
        $query->bindValue(":price", $announce->getPrice());


        $query->execute();
    }

    public function getAllAnnounces() :array
    {
        $query = $this->db->query("SELECT * FROM Announce");
        $query->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, Class\Announce::class);
        return $query->fetchAll();
    }

    public function getAnnounceById(int $id) :object
    {
        $query = 'SELECT * FROM Announce WHERE announce_id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, Class\Announce::class);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function getAnnouncePictures(int $id) : array
    {
        $query = 'SELECT * FROM Picture WHERE announce_id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, Class\Picture::class);
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll();
    }

    public function getAnnounceReviews(int $id) : array
    {
        $query = 'SELECT * FROM Review WHERE announce_id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, Class\Review::class);
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll();
    }

    public function update()
    {

    }

    public function deleteAnnounceByID(int $id) :bool
    {
        $query = $this->db->prepare("DELETE * FROM Announce WHERE id = :id");
        $query->bindValue(":id", $id);
        return $query->execute();
    }
}