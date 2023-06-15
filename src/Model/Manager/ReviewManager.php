<?php

namespace Hetic\ReshomeApi\Model\Manager;

use Hetic\ReshomeApi\Model\Bases\BaseManager;
use Hetic\ReshomeApi\Model\Class;

class ReviewManager extends BaseManager
{
    public function getReviewUser(int $user_id) {
        $query = 'SELECT * FROM User WHERE user_id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, Class\User::class);
        $stmt->execute(['id' => $user_id]);
        return $stmt->fetch();
    }

}