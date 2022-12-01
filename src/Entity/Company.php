<?php

declare(strict_types=1);

namespace App\Entity;

class Company
{
    /** @var string */
    private $size;

    /** @var string */
    private $domain;

    /**
     * @param string $size
     * @param string $domain
     */
    public function __construct(string $size, string $domain)
    {
        $this->size = $size;
        $this->domain = $domain;
    }

    /**
     * @return string
     */
    public function getSize(): string
    {
        return $this->size;
    }

    /**
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

}