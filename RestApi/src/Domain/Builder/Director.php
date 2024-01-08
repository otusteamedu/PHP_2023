<?php

namespace App\Domain\Builder;

class Director
{
    public function constructArticle(BuilderInterface $builder): BuilderInterface
    {
        $builder->reset();
        $builder->setCreationDate();
    }
}
