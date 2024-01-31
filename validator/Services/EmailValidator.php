<?php
// Добавлены строгие типы для параметров методов и возвращаемых значений, что соответствует PSR-12 и PSR-1.

// DRY Введены отдельные приватные методы isValidEmail и isValidDomain для избежания дублирования кода. Теперь проверка на валидность email и домена выполняется в отдельных методах.

// KISS Метод validate  теперь содержит простую последовательность проверок, которая легко читается и понимается.

// SOLID Класс EmailValidator следует принципу единственной ответственности: один класс отвечает только за валидацию email.

// Таким образом, внесенные изменения в код помогают сделать его более читаемым, поддерживаемым и соответствующим стандартам.
declare(strict_types=1);

namespace Rvoznyi\ComposerHello\Services;

class EmailValidator
{
    private string $email;
    public function __construct(string $email)
    {
        $this->email = $email;
    }
    public function validate(): string
    {
        if (!$this->isValidEmail()) {
            return 'Не верный Email';
        }
        [$username, $domain] = explode('@', $this->email);
        if ($this->isValidDomain($domain)) {
            return 'Верный Email';
        }
        return 'Не верный Email';
    }
    private function isValidEmail(): bool
    {
        return filter_var($this->email, FILTER_VALIDATE_EMAIL) !== false;
    }
    private function isValidDomain(string $domain): bool
    {
        return getmxrr($domain, $mxHosts);
    }
}
