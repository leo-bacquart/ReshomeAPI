<?php

namespace Hetic\ReshomeApi\Model\Manager;

use Hetic\ReshomeApi\Model\Bases\BaseManager;
use Hetic\ReshomeApi\Model\Entity;

class ReviewManager extends BaseManager
{
    public function addReview(array $reviewData) : bool
    {
        $query = 'INSERT INTO Review (user_id, announce_id, rate, comment) VALUES (:user_id, :announce_id, :rate, :comment )';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue('user_id', $reviewData['user_id']);
        $stmt->bindValue('announce_id', $reviewData['announce_id']);
        $stmt->bindValue('rate',$reviewData['rate']);
        $stmt->bindValue('comment',$reviewData['comment']);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false; // No rows were inserted
        }
    }

    public function getAnnounceReviews(int $announceId): false|array
    {
        $query = 'SELECT * FROM Review WHERE announce_id = :announceId';
        $stmt = $this->db->prepare($query);
        $stmt->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, Entity\Review::class);
        $stmt->execute(['announceId' => $announceId]);
        return $stmt->fetchAll();
    }

    public function getAnnounceUserReviews(int $announceId, int $userId): false|array
    {
        $query = 'SELECT * FROM Review WHERE announce_id = :announceId AND user_id = :userId';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue('announceId', $announceId);
        $stmt->bindValue('userId', $userId);
        $stmt->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, Entity\Review::class);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getReviewById(int $reviewId)
    {
        $query = 'SELECT * FROM Review WHERE review_id = :reviewId';
        $stmt = $this->db->prepare($query);
        $stmt->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, Entity\Review::class);
        $stmt->execute(['reviewId' => $reviewId]);
        return $stmt->fetch();
    }

    public function deleteReview(Entity\Review $review) : bool
    {
        $query = $this->db->prepare("DELETE FROM Review WHERE review_id = :reviewId");
        $query->bindValue(":reviewId", $review->getReviewId());
        return $query->execute();
    }

}