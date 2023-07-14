<?php

declare(strict_types=1);

namespace Root\App;

use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;

class App
{
    const DEFAULT_ELASTIC_HOST = 'elastic:9200';
    const DEFAULT_ELASTIC_INDEX = 'otus-shop';

    const DEFAULT_MAPPING_FILE = 'mapping.json';
    const DEFAULT_DATA_FILE = 'data.json';

    private string $elasticHost = self::DEFAULT_ELASTIC_HOST;
    private string $elasticIndex = self::DEFAULT_ELASTIC_INDEX;
    private string $mappingFile = self::DEFAULT_MAPPING_FILE;
    private string $dataFile = self::DEFAULT_DATA_FILE;

    private array $params = [];

    private ?Elastic $elastic = null;
    private ?Logger $logger;

    /**
     * @throws AppException
     */
    public function __construct(?string $config = null)
    {
        set_time_limit(0);
        mb_internal_encoding('UTF-8');

        $this->parseArg();
        if (!empty($config)) {
            $this->parseConfig($config);
        }
        $this->logger = new Logger('app');
        $this->logger->pushHandler(new StreamHandler('php://stdout', Level::Info));
    }


    /**
     * @throws ClientResponseException
     * @throws AppException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function run(): void
    {
        if (isset($this->params['help']) || empty($this->params)) {
            $this->help();
            return;
        }

        $this->elastic = new Elastic($this->elasticHost, $this->elasticIndex, $this->logger);

        if (!$this->elastic->exists()) {
            $mapping = file_get_contents($this->mappingFile);
            if ($mapping === false) {
                throw new AppException("Error read mapping file ({$this->mappingFile})");
            }
            $this->elastic->createIndex($mapping);

            $data = file_get_contents($this->dataFile);
            if ($data === false) {
                throw new AppException("Error read data file ({$this->dataFile})");
            }
            $this->elastic->bulk($data);
        }

        $result = $this->elastic->find($this->params);
        $this->tablePrint($result);
    }

    private function parseArg(): void
    {
        $opt = getopt('ht:s:c:p:q:', ['help', 'title:', 'sku:', 'category:', 'price:', 'quantity:', 'shop:']);
        if (!empty($opt)) {
            foreach ($opt as $key => $value) {
                $param = '';
                switch ($key) {
                    case 't':
                    case 'title':
                        $param = 'title';
                        break;
                    case 's':
                    case 'sku':
                        $param = 'sku';
                        break;
                    case 'c':
                    case 'category':
                        $param = 'category';
                        break;
                    case 'p':
                    case 'price':
                        $param = 'price';
                        break;
                    case 'q':
                    case 'quantity':
                        $param = 'quantity';
                        break;
                    case 'shop':
                        $param = 'shop';
                        break;
                    case 'h':
                    case 'help':
                        $param = 'help';
                        break;
                }
                if (!empty($param)) {
                    if (!isset($this->params[$param])) {
                        $this->params[$param] = [];
                    }
                    if (is_array($value)) {
                        $this->params[$param] = array_merge($this->params[$param], $value);
                    } else {
                        $this->params[$param][] = $value;
                    }
                }
            }
        }
    }

    /**
     * @throws AppException
     */
    private function parseConfig(string $config): void
    {
        if (!is_readable($config)) {
            throw new AppException('Error read config file (' . $config . ')');
        }

        $config = parse_ini_file($config, true);
        if (is_array($config) && count($config) > 0) {
            $section = $config['elastic'] ?? [];
            $this->elasticHost = $section['host'] ?? self::DEFAULT_ELASTIC_HOST;
            $this->elasticIndex = $section['index'] ?? self::DEFAULT_ELASTIC_INDEX;
            $section = $config['file'] ?? [];
            $this->mappingFile = __DIR__ . '/../' . $section['mapping'] ?? self::DEFAULT_MAPPING_FILE;
            $this->dataFile = __DIR__ . '/../' . $section['data'] ?? self::DEFAULT_DATA_FILE;
        }
    }


    private function help(): void
    {
        echo "Использование: index.php [OPTIONS]\n\n"
            . "OPTIONS:\n"
            . "\t-t \"значение\", --title=\"значение\"\t Поиск по title\n"
            . "\t-s \"значение\", --sku=\"значение\"\t\t Поиск по sku\n"
            . "\t-c \"значение\", --category=\"значение\"\t Поиск по category\n"
            . "\t-p \"значение\", --price=\"значение\"\t Поиск по price\n"
            . "\t-q \"значение\", --quantity=\"значение\"\t Поиск по quantity\n"
            . "\t--shop=\"значение\"\t\t\t Поиск по shop\n"
            . "\t-h, --help\t\t\t\t Помощь\n"
            . "Пример:\n"
            . "\tindex.php -t \"title 1\" --title=\"title 2\" --q 10 -p \"<1000\"\n"
            . PHP_EOL;
    }

    private function tablePrint(array $data): void
    {
        $columnTitle = [
            'score' => 'Score', 'sku' => 'SKU', 'title' => 'Title', 'category' => 'Category', 'price' => 'Price',
            'stock' => 'Stock'
        ];
        $columnWidth = [];
        $this->tableCalcWidth($columnTitle, $data, $columnWidth);

        echo $this->tableBuildRow($columnWidth, true);
        echo $this->tableBuildRow(
            $columnWidth,
            false,
            $columnTitle['score'],
            $columnTitle['sku'],
            $columnTitle['title'],
            $columnTitle['category'],
            $columnTitle['price'],
            $columnTitle['stock']
        );
        echo $this->tableBuildRow($columnWidth, true);

        if (!empty($data)) {
            /** @var TableRowDto $row */
            foreach ($data as $row) {
                $stock = [];
                if (!empty($row->stock)) {
                    /** @var StockDto $stockRow */
                    foreach ($row->stock as $stockRow) {
                        $stock[] = "{$stockRow->shop} - {$stockRow->stock}";
                    }
                } else {
                    $stock[] = '';
                }

                echo $this->tableBuildRow(
                    $columnWidth,
                    false,
                    $row->score,
                    $row->sku,
                    $row->title,
                    $row->category,
                    $row->price,
                    $stock[0]
                );
                if (count($stock) > 1) {
                    for ($i = 1; $i < count($stock); $i++) {
                        echo $this->tableBuildRow($columnWidth, false, '', '', '', '', '', $stock[$i]);
                    }
                }
            }
        }
        echo $this->tableBuildRow($columnWidth, true);
        echo PHP_EOL;
    }

    private function tableCalcWidth(array $title, array $data, array &$width): void
    {
        foreach ($title as $str) {
            $width[] = mb_strlen($str);
        }

        if (!empty($data)) {
            /** @var TableRowDto $row */
            foreach ($data as $row) {
                $width[0] = max($width[0], mb_strlen("{$row->score}"));
                $width[1] = max($width[1], mb_strlen($row->sku));
                $width[2] = max($width[2], mb_strlen($row->title));
                $width[3] = max($width[3], mb_strlen($row->category));
                $width[4] = max($width[4], mb_strlen("{$row->price}"));

                if (!empty($row->stock)) {
                    /** @var StockDto $stockRow */
                    foreach ($row->stock as $stockRow) {
                        $str = "{$stockRow->shop} - $stockRow->stock";
                        $width[5] = max($width[5], mb_strlen($str));
                    }
                }
            }
        }
    }
    private function tableBuildRow(array $width, bool $line = false, ...$values): string
    {
        $space = $line ? '-' : ' ';
        $delim = $line ? '+' : '|';
        $columnPadding = 1;
        $index = 0;

        $str = $delim;

        foreach ($width as $value) {
            $strText = str_repeat($space, $columnPadding) . ($values[$index] ?? '');
            $str .= $strText . str_repeat($space, $value + $columnPadding + $columnPadding - mb_strlen($strText));
            $str .= $delim;
            $index++;
        }
        $str .= PHP_EOL;
        return $str;
    }
}
