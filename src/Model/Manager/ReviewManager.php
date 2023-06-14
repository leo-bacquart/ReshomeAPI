<?php

namespace Hetic\ReshomeH\Model\Manager;

use Hetic\ReshomeH\Model\Class;

class ReviewManager extends \Hetic\ReshomeH\Model\Bases\BaseManager
{
    public function getReviewUser(int $user_id) {
        $query = 'SELECT * FROM User WHERE user_id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, Class\User::class);
        $stmt->execute(['id' => $user_id]);
        return $stmt->fetch();
    }

}