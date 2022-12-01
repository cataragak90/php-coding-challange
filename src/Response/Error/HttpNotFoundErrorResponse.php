<?php

declare(strict_types=1);

namespace App\Response\Error;

use JMS\Serializer\Annotation as JMS;

class HttpNotFoundErrorResponse extends AbstractErrorResponse
{
    private const PAYLOAD_VALIDATION_ERROR_CODE = 1001;

    /**
     * @JMS\Groups(groups={"prod", "test", "dev"})
     *
     * @var string
     */
    private $message;

    /**
     * @JMS\Groups(groups={"test", "dev"})
     *
     * @var string
     */
    private $errorTrace;

    /**
     * @param string $message
     * @param string $errorTrace
     */
    public function __construct(string $message, string $errorTrace)
    {
        parent::__construct(self::PAYLOAD_VALIDATION_ERROR_CODE);

        $this->message = $message;
        $this->errorTrace = $errorTrace;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getErrorTrace(): string
    {
        return $this->errorTrace;
    }
}