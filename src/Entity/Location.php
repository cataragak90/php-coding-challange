<?php

declare(strict_types=1);

namespace App\Entity;

class Location
{
    /** @var string */
    private $country;

    /** @var string */
    private $city;

    /**
     * @param string $country
     * @param string $city
     */
    public function __construct(string $country, string $city)
    {
        $this->country = $country;
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }
}