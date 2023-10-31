<?php

namespace IilyukDmitryi\App\Infrastructure\TelegramBot\MessageFormatter;

class HtmlFormatter
{
    public static function bold(string $text): string
    {
        return "<b>$text</b>";
    }
    
    public static function italic(string $text): string
    {
        return "<i>$text</i>";
    }
    
    public static function code(string $text): string
    {
        return "<code>$text</code>";
    }
    public static function codeLang(string$text,string $lang): string
    {
        return "<code>$text</code>";
    }
    
    public static function strike(string $text): string
    {
        return "<s>$text</s>";
    }
    
    public static function underline(string $text): string
    {
        return "<u>$text</u>";
    }
}