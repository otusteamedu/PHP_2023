<?php

namespace Common\Infrastructure\Templating;

class Twig
{
    public static function get(string $name)
    {
        $loader = new \Twig\Loader\FilesystemLoader(['.'], config()->get('twig.root_path'));
        $twig = new \Twig\Environment($loader);
        return $twig->load($name);
    }
}