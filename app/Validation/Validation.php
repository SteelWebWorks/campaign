<?php declare(strict_types = 1);

namespace App\Validation;

use Carbon\Carbon;

class Validation
{
    /**
     * @param Carbon|string $date
     * @return Carbon
     */
    public function validateDate(Carbon | string $date) : Carbon
    {
        if (!$date instanceof Carbon) {
            try {
                $date = Carbon::parse($date);
            } catch (\InvalidArgumentException $e) {
                throw new \InvalidArgumentException('Parameter must be a valid date string');
            }
        }
        return $date;
    }

}