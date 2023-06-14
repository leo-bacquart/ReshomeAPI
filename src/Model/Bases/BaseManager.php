<?php

namespace Hetic\ReshomeH\Model\Bases;
use Hetic\ReshomeH\Factories\PDOFactory;

abstract class BaseManager
{
    protected \PDO $db;
    public function __construct()
    {
        $this->db = (new \Hetic\ReshomeH\Factories\PDOFactory)->getConnection();
    }
}