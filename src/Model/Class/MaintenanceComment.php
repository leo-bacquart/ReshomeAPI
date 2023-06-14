<?php

namespace Hetic\ReshomeH\Model\Class;
use Hetic\ReshomeH\model\Bases\BaseClass;

class MaintenanceComment extends BaseClass
{
    private $announce_id;
    private $status;
    private $comment;
    private $image_path;
    private $comment_id;

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

    public function getComment()
    {
        return $this->comment;
    }

    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    public function getImagePath()
    {
        return $this->image_path;
    }

    public function setImagePath($image_path)
    {
        $this->image_path = $image_path;
    }

    public function getCommentId()
    {
        return $this->comment_id;
    }

    public function setCommentId($comment_id)
    {
        $this->comment_id = $comment_id;
    }

    public static function create($data)
    {
    }

    public static function find($announce_id, $comment_id)
    {
    }

    public function update()
    {
    }

    public function delete()
    {
    }
}
