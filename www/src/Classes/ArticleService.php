<?php

declare(strict_types=1);

namespace Yalanskiy\ActiveRecord\Classes;

/**
 * Service class Article
 */
class ArticleService
{
    /**
     * Short columns list
     * field => column title
     */
    public static array $shortData = [
        'id' => 'ID',
        'title' => 'Title',
        'text' => 'Text'
    ];
/**
     * Full columns list
     * field => column title
     */
    public static array $fullData = [
        'id' => 'ID',
        'title' => 'Title',
        'text' => 'Text',
        'tags' => 'Tags'
    ];
    public static string $tagsSeparator = PHP_EOL;
}
