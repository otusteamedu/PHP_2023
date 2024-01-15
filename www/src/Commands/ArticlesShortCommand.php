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

/**
 * Get Short list of Articles
 */
class ArticlesShortCommand extends Command
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
            ->setName('articles:short')
            ->setDescription("Get short list of articles (without tags)")
            ->setHelp("Get short list of articles (without tags)");
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $articles = (new Article($this->pdo))->findAll();

        $table = new Table($output);
        $table->setHeaders(array_values(ArticleService::$shortData));

        /** @var Article $article */
        foreach ($articles as $article) {
            $row = [];
            foreach (ArticleService::$shortData as $field => $title) {
                $method = "get" . ucfirst($field);
                $row[] = $article->$method();
            }
            $table->addRow($row);
        }

        $table->render();

        return Command::SUCCESS;
    }
}
