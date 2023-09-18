<?php

namespace IilyukDmitryi\App\Infrastructure\Config;

class FileIni
{
    private const CONFIG_PATH = 'app.ini';
    private array $config = [];

    public function __construct()
    {
        $this->read();
    }

    private function read(): void
    {
        $this->config = parse_ini_file(self::CONFIG_PATH) ?: [];
    }

    public function getSenderName(): string
    {
        return $this->config['sender'];
    }

    /**
     * @return string
     */
    public function getReciverName(): string
    {
        return $this->config['reciver'];
    }

    public function getReciverHost(): string
    {
        return $this->config['reciver_host'];
    }

    /**
     * @return string
     */
    public function getReciverPort(): int
    {
        return (int)$this->config['reciver_port'];
    }

    /**
     * @return string
     */
    public function getReciverUser(): string
    {
        return $this->config['reciver_user'];
    }

    /**
     * @return string
     */
    public function getReciverPass(): string
    {
        return $this->config['reciver_pass'];
    }

    /**
     * @return string
     */
    public function getReciverQueue(): string
    {
        return $this->config['reciver_queue'];
    }

    /**
     * @return string
     */
    public function getReciveTime(): int
    {
        return (int)$this->config['recive_time'];
    }

    /**
     * @return string
     */
    public function getSenderHost(): string
    {
        return $this->config['sender_host'];
    }

    /**
     * @return int
     */
    public function getSenderPort(): int
    {
        return (int)$this->config['sender_port'];
    }

    /**
     * @return string
     */
    public function getSenderUser(): string
    {
        return $this->config['sender_user'];
    }

    /**
     * @return string
     */
    public function getSenderPass(): string
    {
        return $this->config['sender_pass'];
    }

    /**
     * @return string
     */
    public function getSenderQueue(): string
    {
        return $this->config['sender_queue'];
    }

    /**
     * @return string
     */
    public function getMailerSmptHost(): string
    {
        return $this->config['mailer_smtp_host'];
    }

    /**
     * @return string
     */
    public function getMailerSmptUser(): string
    {
        return $this->config['mailer_smtp_user'];
    }

    /**
     * @return string
     */
    public function getMailerSmptPass(): string
    {
        return $this->config['mailer_smtp_pass'];
    }

    /**
     * @return string
     */
    public function getMailerSmptPort(): string
    {
        return $this->config['mailer_smtp_port'];
    }

    /**
     * @return string
     */
    public function getMailerSmptEmailFrom(): string
    {
        return $this->config['mailer_smtp_email_from'];
    }
}
