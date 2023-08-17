<?php

declare(strict_types=1);

namespace Art\Code\Domain\Model;

class Response
{
    public const HTTP_OK = 200;

    public const HTTP_BAD_REQUEST = 400;

    public const HTTP_PROTOCOL_VERSION = '1.0';

    public array $headers;

    protected string $content;

    protected string $version;

    protected int $statusCode;

    protected string $statusText;

    public static array $statusTexts = [
        200 => 'OK',
        400 => 'Bad Request',
    ];

    /**
     * @param string|null $content
     * @param int $status
     * @param array $headers
     */
    public function __construct(?string $content = '', int $status = self::HTTP_OK, array $headers = [])
    {
        $this->headers = $headers;
        $this->setContent($content);
        $this->setStatusCode($status);
        $this->setProtocolVersion(self::HTTP_PROTOCOL_VERSION);
    }

    /**
     * @param string|null $content
     * @return void
     */
    public function setContent(?string $content): void
    {
        $this->content = $content ?? '';
    }

    /**
     * @param int $code
     * @return void
     */
    public function setStatusCode(int $code): void
    {
        $this->statusCode = $code;
        $this->statusText = self::$statusTexts[$code];
    }

    /**
     * @param string $version
     * @return void
     */
    public function setProtocolVersion(string $version): void
    {
        $this->version = $version;
    }

    /**
     * @return void
     */
    public function sendHeaders(): void
    {
        header(sprintf('HTTP/%s %s %s', $this->version, $this->statusCode, $this->statusText), true, $this->statusCode);
    }

    /**
     * @return string
     */
    public function sendContent(): string
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function send(): string
    {
        $this->sendHeaders();

        return $this->sendContent();
    }
}
