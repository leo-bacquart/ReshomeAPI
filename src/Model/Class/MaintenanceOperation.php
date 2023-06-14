<?php

namespace Hetic\ReshomeH\Model\Class;
use Hetic\ReshomeH\model\Bases\BaseClass;

class MaintenanceOperation extends BaseClass
{
    private $announce_id;
    private $status;
    private $operation_id;

    public function getAnnounceId()
    {
        return $this->announce_id;
    }

    public function setAnnounceId($announce_id)
    {
        $this->announce_id = $announce_id;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getOperationId()
    {
        return $this->operation_id;
    }

    public function setOperationId($operation_id)
    {
        $this->operation_id = $operation_id;
    }

    public static function create($data)
    {
    }

    public static function find($announce_id, $operation_id)
    {
    }

    public function update()
    {
    }

    public function delete()
    {
    }
}
