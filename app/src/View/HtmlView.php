<?php

declare(strict_types=1);

namespace Imitronov\Hw4\View;

final class HtmlView implements View
{
    public function __construct(
        private readonly string $templatePath,
        private readonly string $title,
        private readonly array $params = [],
    ) {
    }

    public function output(): void
    {
        extract([...$this->params]);

        ob_start();
        require sprintf(
            '%s/template/%s.php',
            dirname(__DIR__, 2),
            basename($this->templatePath),
        );
        $content = ob_get_contents();
        ob_clean();

        $this->requireLayout($this->title, $content);
    }

    private function requireLayout($title, $content): void
    {
        require sprintf(
            '%s/template/_layout.php',
            dirname(__DIR__, 2),
        );
    }
}
