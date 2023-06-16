<?php

namespace Hetic\ReshomeApi\Model\Entity;
use Hetic\ReshomeApi\Model\Bases\BaseClass;

class Feature extends BaseClass
{
    private string $content;
    private int $feature_id;

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getFeatureId()
    {
        return $this->feature_id;
    }

    public function setFeatureId($feature_id)
    {
        $this->feature_id = $feature_id;
    }

    public static function create($data)
    {
        // Code pour créer une nouvelle caractéristique
    }

    public function update()
    {
        // Code pour mettre à jour cette caractéristique
    }

    public function delete()
    {
        // Code pour supprimer cette caractéristique
    }
}
