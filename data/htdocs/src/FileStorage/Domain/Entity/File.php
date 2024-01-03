<?php

namespace FileStorage\Domain\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="File",
 *     description="File model",
 * )
 */
#[Entity, Table(name: 'files')]
final class File
{
    /**
     * @var int|null The unique identifier of the file
     * @OA\Property(
     *     type="integer",
     *     description="The unique identifier of the file"
     * )
     */
    #[Id, Column(type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    private ?int $id;

    /**
     * @var string
     * @OA\Property(
     *     type="string",
     *     description="The module of the file"
     * )
     */
    #[Column(name: 'module', type: 'string', length: 255)]
    private string $module;

    /**
     * @var string
     * @OA\Property(
     *     type="string",
     *     description="The original name of the file"
     * )
     */
    #[Column(name: 'original_name', type: 'string', length: 255)]
    private string $originalName;

    /**
     * @var string
     * @OA\Property(
     *     type="string",
     *     description="The type of the file"
     * )
     */
    #[Column(type: 'string', length: 255)]
    private string $type;

    /**
     * @var string
     * @OA\Property(
     *     type="string",
     *     description="The size of the file"
     * )
     */
    #[Column(type: 'integer')]
    private string $size;

    /**
     * @var string
     * @OA\Property(
     *     type="string",
     *     description="The path of the file"
     * )
     */
    #[Column(type: 'string', length: 255)]
    private string $path;

    /**
     * @param ?int $id
     * @param string $module
     * @param string $originalName
     * @param string $type
     * @param string $size
     * @param string $path
     */
    public function __construct(?int $id, string $module, string $originalName, string $type, string $size, string $path)
    {
        $this->id = $id;
        $this->module = $module;
        $this->originalName = $originalName;
        $this->type = $type;
        $this->size = $size;
        $this->path = $path;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return File
     */
    public function setId(?int $id): File
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getOriginalName(): string
    {
        return $this->originalName;
    }

    /**
     * @param string $originalName
     * @return File
     */
    public function setOriginalName(string $originalName): File
    {
        $this->originalName = $originalName;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return File
     */
    public function setType(string $type): File
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getSize(): string
    {
        return $this->size;
    }

    /**
     * @param string $size
     * @return File
     */
    public function setSize(string $size): File
    {
        $this->size = $size;
        return $this;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return File
     */
    public function setPath(string $path): File
    {
        $this->path = $path;
        return $this;
    }
}
