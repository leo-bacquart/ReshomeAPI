<?php

namespace Hetic\ReshomeApi\Utils;

use Hetic\ReshomeApi\Model\Entity;
use Hetic\ReshomeApi\Model\Manager;

class ReviewHelper
{
    public static function hasReviewedThisAnnounce(Entity\User $user, Entity\Announce $announce) : int
    {
        $reviewManager = new Manager\ReviewManager();
        $userReviews = $reviewManager->getAnnounceUserReviews($announce->getAnnounceId(), $user->getUserId());

        if (!$userReviews) {
            return 0;
        }
        return count($userReviews);
    }
}