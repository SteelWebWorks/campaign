<?php declare(strict_types = 1);

namespace App\Services;

use App\Classes\Campaign;
use App\Entities\BlogEntity;
use App\Entities\Entity;
use Doctrine\Common\Collections\ArrayCollection;

class CampaignService
{
    public function __construct()
    {
    }

    public function validateCampaigns(ArrayCollection $campaigns) : array
    {
        $validatedCampaigns = [];
        /**
         * @var Campaign $campaign
         */
        foreach ($campaigns as $campaign) {
            $valid = true;
            foreach ($campaign->entities as $entity) {
                if ($entity instanceof BlogEntity && in_array($campaign->start->dayOfWeek, [0,6])) {
                    $valid = false;
                    break;
                }
            }
            if ($valid) {
                $valid = !$this->isCampaignsOverlapByEntity($campaigns, $campaign);

            }

            $validatedCampaigns[$campaign->name] =  ($valid) ? 'valid' : 'invalid';
        }

        return $validatedCampaigns;
    }

    private function isCampaignsOverlapByEntity(ArrayCollection $campaigns, Campaign $campaign) : bool
    {
        foreach ($campaigns as $filterCampaign) {
            if ($filterCampaign->getId() !== $campaign->getId()
                && $filterCampaign->start->lte($campaign->end)
                && $filterCampaign->end->gte($campaign->start)) {
                foreach ($filterCampaign->entities as $entity) {
                    if ($campaign->entities->contains($entity)) {
                        return true;
                    }
                }
            }
        }
        return false;
    }
}