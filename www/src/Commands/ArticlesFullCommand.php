<?php

declare(strict_types=1);

namespace Yalanskiy\ActiveRecord\Commands;

use PDO;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Yalanskiy\ActiveRecord\Classes\ArticleService;
use Yalanskiy\ActiveRecord\Models\Article;
use Yalanskiy\ActiveRecord\Models\Tag;

/**
 * Get Full list of Articles
 */
class ArticlesFullCommand extends Command
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        parent::__construct();

        $this->pdo = $pdo;
    }

    protected function configure(): void
    {
        $this
            ->setName('articles:full')
            ->setDescription("Get full list of articles (without tags)")
            ->setHelp("Get full list of articles (without tags)");
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $articles = (new Article($this->pdo))->findAll();

        $table = new Table($output);
        $table->setHeaders(array_values(ArticleService::$fullData));

        /** @var Article $article */
        foreach ($articles as $article) {
            $row = [];
            foreach (ArticleService::$fullData as $field => $title) {
                $method = "get" . ucfirst($field);
                $value = $article->$method();
                if ($field == 'tags') {
                    $tagNames = [];
                    /** @var Tag $item */
                    foreach ($value as $item) {
                        $tagNames[] = $item->getName();
                    }
                    $value = implode(ArticleService::$tagsSeparator, $tagNames);
                }
                $row[] = $value;
            }
            $table->addRow($row);
        }

        $table->render();

        return Command::SUCCESS;
    }
}
