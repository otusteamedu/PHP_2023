<?php

declare(strict_types=1);

namespace Dshevchenko\Emailchecker;

class Checker
{
    private \Memcached $cache;
    private string $lastDescription;

    public function __construct()
    {
        // Инициализируем объект кэша
        $this->cache = new \Memcached();
        $this->cache->addServer('memcached', 11211);
    }

    /**
     * Проверяет, является ли предоставленный адрес электронной почты действительным,
     * и сохраняет результат в кэше
     *
     * @param string $email
     * @return bool
     */
    public function check(string $email): bool
    {
        // Проверяем в кэше
        $cachedValue = $this->cache->get($email);

        if ($this->cache->getResultCode() === \Memcached::RES_SUCCESS) {
            if ($cachedValue === true) {
                $this->lastDescription = '';
            } else {
                // Если из кэша доставли значение false - достаем и описание проблемы валидации
                $this->lastDescription = $this->cache->get($email . ':descr');
            }

            return $cachedValue;
        }

        try {
            // Проверка формата email
            if (strpos($email, '@') === false) {
                throw new \Exception("Email must contain @");
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new \Exception('Incorrect format');
            }

            // Проверка MX-записи домена
            $emailParts = explode('@', $email);
            $domain = end($emailParts);

            if (!checkdnsrr($domain, 'MX')) {
                throw new \Exception('Invalid MX-record');
            }
        } catch (\Exception $e) {
            // Запоминаем описание проблемы
            $this->lastDescription = $e->getMessage();

            // Сохраняем отрицательный результат и причину в кэш
            $this->cache->set($email, false);
            $this->cache->set($email . ':descr', $this->lastDescription);
            return false;
        }

        // Очищаем описание проблемы
        $this->lastDescription = '';

        // Сохраняем положительный результат в кэш
        $this->cache->set($email, true);
        return true;
    }

    /**
     * Возвращает последнее описание ошибки при проверке достоверности
     *
     * @return string
     */
    public function getLastDescription(): string
    {
        return $this->lastDescription;
    }
}
