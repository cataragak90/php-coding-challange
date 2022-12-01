<?php

declare(strict_types=1);

namespace App\Dto\Company;

use JMS\Serializer\Annotation as JMS;

class CompanyResponseDto
{
    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    public $size;

    /**
     * @JMS\Type("string")
     *
     * @var string
     */
    public $domain;

    /**
     * @param string $size
     * @param string $domain
     */
    public function __construct(string $size, string $domain)
    {
        $this->size = $size;
        $this->domain = $domain;
    }
}