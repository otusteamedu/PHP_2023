<?php

namespace src\inside\typeClass;

class StringClass implements CustomizableInterface
{
    private string $val;

    public static function build(): self // @fixme use trait buildable or creatable
    {
        return new self();
    }

    public function get(): string
    {
        return $this->val;
    }

    private function set(string $val): self
    {
        $this->val = $val;
        return $this;
    }

    public function toString(): string
    {
        return $this->val;
    }

    public function fromString(string $val): self
    {
        $this->val = $val;
        return $this;
    }

    public static function cast(string $value): self
    {
        $cast = new self();
        $cast->set($value);
        return $cast;
    }

    public function customize($value): self
    {
        $this->set($value);
        return $this;
    }

    public function from($value): self
    {
        $this->set($value);
        return $this;
    }
}
