<?php

namespace Hetic\ReshomeApi\Controller;

use Hetic\ReshomeApi\Model\Manager\FeatureManager;

class FeatureController
{
    private FeatureManager $featureManager;

    public function __construct()
    {
        $this->featureManager = new FeatureManager();
    }

    public function getFeatureById($id)
    {
        $feature = $this->featureManager->getFeatureById($id);
        if ($feature) {
            echo json_encode($feature->jsonSerialize());
        } else {
            echo json_encode(['message' => 'Feature not found' ]);
        }
    }


}

