<?php declare(strict_types=1);

namespace App\Factory;

use App\Classes\Campaign;
use App\Validation\Validation;
use Carbon\Carbon;

class CampaignFactory
{

    /**
     * @param Validation $validation
     */
    public function __construct(protected Validation $validation)
    {
    }

    /**
     * @param string $name
     * @param Carbon|string $start
     * @param Carbon|string $end
     * @return Campaign
     */
    public function createCampaign(string $name, Carbon | string $start, Carbon | string $end) : Campaign
    {

        try {
            $start = $this->validation->validateDate($start);
            $end = $this->validation->validateDate($end);
        } catch (\InvalidArgumentException $e) {
            throw new \InvalidArgumentException($e->getMessage());
        }

        return new Campaign($name, $start, $end);
    }
}