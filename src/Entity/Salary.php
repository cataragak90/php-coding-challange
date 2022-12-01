<?php

declare(strict_types=1);

namespace App\Entity;

use phpDocumentor\Reflection\Types\This;

class Salary
{
    /** @var float */
    private $value;

    /** @var string */
    private $currency;

    /**
     * @param float $value
     * @param string $currency
     */
    public function __construct(float $value, string $currency)
    {
        $this->value = $value;
        $this->currency = $currency;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value . ' ' . $this->currency;
    }
}