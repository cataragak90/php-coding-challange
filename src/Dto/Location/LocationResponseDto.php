<?php

declare(strict_types=1);

namespace App\Dto\Location;

use JMS\Serializer\Annotation as JMS;

class LocationResponseDto
{
    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    public $country;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    public $city;

    /**
     * @param string $country
     * @param string $city
     */
    public function __construct(string $country, string $city)
    {
        $this->country = $country;
        $this->city = $city;
    }
}