<?php

namespace Hetic\ReshomeApi\Model\Manager;

use Hetic\ReshomeApi\Model\Bases\BaseManager;
use Hetic\ReshomeApi\Model\Entity;
use PDO;

class AnnounceManager extends BaseManager
{
    public function addAnnounce(array $announceData): string|false
    {
        $query = 'INSERT INTO Announce (title, description, neighborhood, arrondissement, bedroom_number, capacity, type, area, price) VALUES (:title, :description, :neighborhood, :arrondissement, :bedroom_number, :capacity, :type, :area, :price)';
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'title' => $announceData['title'],
            'description' => $announceData['description'],
            'neighborhood' => $announceData['neighborhood'],
            'arrondissement' => $announceData['arrondissement'],
            'bedroom_number' => $announceData['bedroom_number'],
            'capacity' => $announceData['capacity'],
            'type' => $announceData['type'],
            'area' => $announceData['area'],
            'price' => $announceData['price']
        ]);

        if ($stmt->rowCount() > 0) {
            return $this->db->lastInsertId();
        } else {
            return false; // No rows were inserted
        }
    }

    public function getAllAnnounces() :array
    {
        $query = $this->db->query("SELECT * FROM Announce");
        $query->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, Entity\Announce::class);
        return $query->fetchAll();
    }

    public function getAnnouncePage($number) : array
    {
        $offset = ($number - 1) * 10;
        $query = "SELECT * FROM Announce ORDER BY announce_id LIMIT 10 OFFSET :offset";
        $stmt = $this->db->prepare($query);
        $stmt->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, Entity\Announce::class);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAnnounceById(int $id) :object
    {
        $query = 'SELECT * FROM Announce WHERE announce_id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, Entity\Announce::class);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function getAnnouncePictures(int $id) : array
    {
        $query = 'SELECT * FROM Picture WHERE announce_id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, Entity\Picture::class);
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll();
    }

    public function getAnnounceReviews(int $id) : array
    {
        $query = 'SELECT * FROM Review WHERE announce_id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, Entity\Review::class);
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll();
    }

    public function getAnnounceBySearch(string $search)
    {
        $query = "SELECT * FROM Announce WHERE title LIKE :search LIMIT 10";
        $stmt = $this->db->prepare($query);
        $stmt->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, Entity\Review::class);
        $stmt->execute(['search' => htmlspecialchars($search)]);
    }

    public function update()
    {

    }

    public function deleteAnnounceByID(int $id) :bool
    {
        $query = $this->db->prepare("DELETE FROM Announce WHERE announce_id = :id");
        $query->bindValue(":id", $id);
        return $query->execute();
    }
}