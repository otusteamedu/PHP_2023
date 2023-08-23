<?php

declare(strict_types=1);

namespace Art\Code\Domain;

class Property
{
    protected string $type;
    protected ?string $cadastralInformation = null;

    /**
     * @param string $type
     */
    public function __construct(string $type = 'residential')
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getCadastralInformation(): string
    {
        return $this->cadastralInformation;
    }

    public function store()
    {
        // save in db
    }

}