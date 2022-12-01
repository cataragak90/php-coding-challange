<?php

declare(strict_types=1);

namespace App\Response\Error;

use JMS\Serializer\Annotation as JMS;

abstract class AbstractErrorResponse
{
    /**
     * @JMS\Groups(groups={"prod", "test", "dev"})
     *
     * @var int
     */
    private $code;

    /**
     * @param int $code
     */
    public function __construct(int $code)
    {
        $this->code = $code;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }
}