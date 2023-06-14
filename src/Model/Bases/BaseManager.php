<?php

namespace Hetic\ReshomeApi\Model\Bases;

use Hetic\ReshomeApi\Database\PDOFactory;

abstract class BaseManager
{
    protected \PDO $db;
    public function __construct()
    {
        $this->db = (new PDOFactory())->getConnection();
    }
}