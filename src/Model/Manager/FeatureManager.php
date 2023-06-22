<?php

namespace Hetic\ReshomeApi\Model\Manager;

use Hetic\ReshomeApi\Model\Bases\BaseManager;
use Hetic\ReshomeApi\Model\Entity;

class FeatureManager extends BaseManager
{
    public function getAnnounceFeaturesById(int $announce_id) : array
    {
        $query = $this->db->prepare("SELECT * FROM AnnounceFeature as af INNER JOIN Feature as f ON f.id = af.feature_id WHERE announce_id =:announceId");
        $query->bindValue(":announce_id", $announce_id);
        $query->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, "Feature");

        return $query->fetchAll();
    }

    public function createFeature(Entity\Feature $feature) : bool
    {
        $query = $this->db->prepare("INSERT INTO Feature (content,feature_id) VALUES (:content, :feature_id)");
        $query->bindValue(":content", $feature->getContent());
        $query->bindValue(":feature_id", $feature->getFeatureId());

        return $query->execute();
    }

    public function updateFeature(Entity\Feature $feature) : bool
    {
        $query = $this->db->prepare("UPDATE Feature SET content = :content WHERE id= :featureId");
        $query->bindValue(":content", $feature->getContent());
        $query->bindValue(":featureId", $feature->getFeatureId());

        return $query->execute();
    }

    public function deleteFeature(Entity\Feature $feature) : bool
    {
        $query = $this->db->prepare("DELETE * FROM Feature WHERE id = :featureId");
        $query->bindValue(":featureId", $feature->getFeatureId());

        return $query->execute();
    }
    public function addFeatureToAnnounce(Entity\Feature $feature, $announce_id) : bool
    {
        $query = $this->db->prepare("INSERT INTO AnnounceFeature (announce_id,feature_id) VALUES (:announceId, :featureId)");
        $query->bindValue(":announceId", $announce_id);
        $query->bindValue(":featureId", $feature->getFeatureId());

        return $query->execute();
    }

    public function removeFeatureFromAnnounce(Entity\Feature $feature, $announce_id) : bool
    {
        $query = $this->db->prepare("DELETE * FROM AnnounceFeature WHERE announce_id = :announceId AND feature_id = :featureId");
        $query->bindValue(":announceId", $announce_id);
        $query->bindValue(":featureId", $feature->getFeatureId());

        return $query->execute();
    }

    public function getFeatureById(int $id): Entity\Feature
    {
        $query = $this->db->prepare("SELECT * FROM Feature WHERE feature_id = :id");
        $query->bindValue(":id", $id);
        $query->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, Entity\Feature::class);
        $query->execute();

        return $query->fetch();
    }

    public function getAnnounceFeaturesById(int $announce_id) : array
    {
        $query = $this->db->prepare("SELECT * FROM AnnounceFeature as af INNER JOIN Feature as f ON f.id = af.feature_id WHERE announce_id =:announceId");
        $query->bindValue(":announce_id", $announce_id);
        $query->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, "Feature");

        return $query->fetchAll();
    }



}