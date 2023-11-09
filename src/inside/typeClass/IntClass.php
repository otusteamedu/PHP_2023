<?php

namespace src\inside\typeClass;

class IntClass implements CustomizableInterface
{
    private int $val;

    public static function build(): self // @fixme use trait buildable or creatable
    {
        return new self();
    }

    private function get(): int
    {
        return $this->val;
    }

    private function set(int $val): self
    {
        $this->val = $val;
        return $this;
    }

    public function toInt(): int
    {
        return $this->val;
    }

    public function fromInt(int $val): self
    {
        $this->val = $val;
        return $this;
    }

    public static function cast(int $value): self
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
