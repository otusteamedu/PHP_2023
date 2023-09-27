<?php

namespace IilyukDmitryi\App\Infrastructure\Config;

use InvalidArgumentException;

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

    public function getMessangerName(): string
    {
        return $this->config['messanger'] ?? throw new InvalidArgumentException(
            "The config parameter messanger is not a valid config parameter"
        );
    }

    /**
     * @return string
     */
    public function getMessangerHost(): string
    {
        return $this->config['messanger_host'] ?? throw new InvalidArgumentException(
            "The config parameter messanger_host is not a valid config parameter"
        );
    }

    /**
     * @return int
     */
    public function getMessangerPort(): int
    {
        return (int)$this->config['messanger_port'] ?? throw new InvalidArgumentException(
            "The config parameter messanger_port is not a valid config parameter"
        );
    }

    /**
     * @return string
     */
    public function getMessangerUser(): string
    {
        return $this->config['messanger_user'] ?? throw new InvalidArgumentException(
            "The config parameter messanger_user is not a valid config parameter"
        );
    }

    /**
     * @return string
     */
    public function getMessangerPass(): string
    {
        return $this->config['messanger_pass'] ?? throw new InvalidArgumentException(
            "The config parameter messanger_pass is not a valid config parameter"
        );
    }

    public function getMessangerReciveTime()
    {
        return $this->config['messanger_recive_time'] ?? throw new InvalidArgumentException(
            "The config parameter messanger_recive_time is not a valid config parameter"
        );
    }


    /**
     * @return string
     */
    public function getMailerName(): string
    {
        return $this->config['mailer'] ?? throw new InvalidArgumentException(
            "The config parameter mailer is not a valid config parameter"
        );
    }

    /**
     * @return string
     */
    public function getMailerSmptHost(): string
    {
        return $this->config['mailer_smtp_host'] ?? throw new InvalidArgumentException(
            "The config parameter mailer_smtp_host is not a valid config parameter"
        );
    }

    /**
     * @return string
     */
    public function getMailerSmptUser(): string
    {
        return $this->config['mailer_smtp_user'] ?? throw new InvalidArgumentException(
            "The config parameter mailer_smtp_user is not a valid config parameter"
        );
    }

    /**
     * @return string
     */
    public function getMailerSmptPass(): string
    {
        return $this->config['mailer_smtp_pass'] ?? throw new InvalidArgumentException(
            "The config parameter mailer_smtp_pass is not a valid config parameter"
        );
    }

    /**
     * @return string
     */
    public function getMailerSmptPort(): string
    {
        return $this->config['mailer_smtp_port'] ?? throw new InvalidArgumentException(
            "The config parameter mailer_smtp_port is not a valid config parameter"
        );
    }

    /**
     * @return string
     */
    public function getMailerSmptEmailFrom(): string
    {
        return $this->config['mailer_smtp_email_from'] ?? throw new InvalidArgumentException(
            "The config parameter mailer_smtp_email_from is not a valid config parameter"
        );
    }

    public function getNameStorage(): string
    {
        return $this->config['storage'] ?? throw new InvalidArgumentException(
            "The config parameter storage is not a valid config parameter"
        );
    }

    public function getRadisHost(): string
    {
        return $this->config['radis_host'] ?? throw new InvalidArgumentException(
            "The config parameter radis_host is not a valid config parameter"
        );
    }

    /**
     * @return string
     */
    public function getRadisPort(): string
    {
        return $this->config['radis_port'] ?? throw new InvalidArgumentException(
            "The config parameter radis_port is not a valid config parameter"
        );
    }

    public function getMysqlHost(): string
    {
        return $this->config['mysql_host'] ?? throw new InvalidArgumentException(
            "The config parameter mysql_host is not a valid config parameter"
        );
    }

    /**
     * @return string
     */
    public function getMysqlUser(): string
    {
        return $this->config['mysql_user'] ?? throw new InvalidArgumentException(
            "The config parameter mysql_user is not a valid config parameter"
        );
    }

    /**
     * @return string
     */
    public function getMysqlPass(): string
    {
        return $this->config['mysql_pass'] ?? throw new InvalidArgumentException(
            "The config parameter mysql_pass is not a valid config parameter"
        );
    }

    /**
     * @return string
     */
    public function getMysqlDbName(): string
    {
        return $this->config['mysql_dbname'] ?? throw new InvalidArgumentException(
            "The config parameter mysql_dbname is not a valid config parameter"
        );
    }

}
