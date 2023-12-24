<?php

declare(strict_types=1);

namespace Klobkovsky\App\DataMapper;

class Manufacturer
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var int
     */
    private $parentId;

    /**
     * @var int
     */
    private $level;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $rusname;

    /**
     * @var string
     */
    private $alias;

    /**
     * @param int $id
     * @param string $name
     * @param string $rusname
     * @param string $alias
     * @param int $level
     */
    public function __construct(
        int $id,
        int $parentId,
        int $level,
        string $name,
        string $rusname,
        string $alias
    ) {
        $this->id = $id;
        $this->parentId = $parentId;
        $this->level = $level;
        $this->name = $name;
        $this->rusname = $rusname;
        $this->alias = $alias;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }


    /**
     * @param int $parentId
     */
    public function getParentId(): int
    {
        return $this->parentId;
    }

    /**
     * @param int $parentId
     * @return self
     */
    public function setParentId(int $parentId)
    {
        $this->parentId = $parentId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getRusname(): string
    {
        return $this->rusname;
    }

    /**
     * @param string $rusname
     * @return self
     */
    public function setRusname(string $rusname): self
    {
        $this->rusname = $rusname;
        return $this;
    }

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * @param string $alias
     * @return self
     */
    public function setAlias(string $alias): self
    {
        $this->alias = $alias;
        return $this;
    }

    /**
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * @param int $level
     * @return self
     */
    public function setLevel(int $level): self
    {
        $this->level = $level;
        return $this;
    }
}
