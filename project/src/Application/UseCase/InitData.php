<?php

declare(strict_types=1);

namespace Vp\App\Application\UseCase;

use Exception;
use Vp\App\Application\Contract\InitDataInterface;
use Vp\App\Application\Dto\Output\ResultInit;
use Vp\App\Application\Message;
use Vp\App\Exceptions\AddEntityFailed;
use Vp\App\Exceptions\FindEntityFailed;
use Vp\App\Infrastructure\DataBase\Contract\DatabaseInterface;

class InitData implements InitDataInterface
{
    private \PDO $conn;

    public function __construct(DatabaseInterface $database)
    {
        $this->conn = $database->getConnection();
    }

    public function work(): ResultInit
    {
        $this->dropLandPlotTableForTree();
        $this->dropLandPlotTableForGrid();
        $this->dropLandPlotTable();
        $this->dropLandPlotTypeTable();

        $this->createLandPlotTypeTable();
        $this->createLandPlotTableForTree();
        $this->createLandPlotTable();
        $this->createLandPlotTableForGrid();

        try {
            $this->fillData();
        } catch (AddEntityFailed | FindEntityFailed $e) {
            return new ResultInit(false, $e->getMessage());
        }

        return new ResultInit(true, Message::SUCCESS_CREATE_DATA);
    }

    private function dropLandPlotTableForTree(): void
    {
        $this->conn->exec('DROP TABLE IF EXISTS tree_land_plots');
    }

    private function dropLandPlotTableForGrid(): void
    {
        $this->conn->exec('DROP TABLE IF EXISTS grid_land_plots');
    }

    private function dropLandPlotTable(): void
    {
        $this->conn->exec('DROP TABLE IF EXISTS land_plots');
    }

    private function dropLandPlotTypeTable(): void
    {
        $this->conn->exec('DROP TABLE IF EXISTS types');
    }

    private function createLandPlotTypeTable(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS types (
                        id serial PRIMARY KEY,
                        name VARCHAR(50) NOT NULL,
                        code VARCHAR(50) NOT NULL
                        )";
        $this->conn->exec($sql);
    }

    private function createLandPlotTableForTree(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS tree_land_plots (
                        id serial PRIMARY KEY,
                        number INT NOT NULL,
                        name VARCHAR(50) NOT NULL,
                        parent_id INT,
                        type_id INT NOT NULL,
                        CONSTRAINT c_fk_type FOREIGN KEY (type_id) REFERENCES types (id) ON DELETE CASCADE,
                        CONSTRAINT c_fk_parent FOREIGN KEY (parent_id) REFERENCES tree_land_plots (id) ON DELETE CASCADE
                        )";
        $this->conn->exec($sql);
    }

    private function createLandPlotTable(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS land_plots (
                        id serial PRIMARY KEY,
                        number INT NOT NULL,
                        name VARCHAR(50) NOT NULL,
                        type_id INT NOT NULL,
                        CONSTRAINT c_fk_type FOREIGN KEY (type_id) REFERENCES types (id) ON DELETE CASCADE
                        )";
        $this->conn->exec($sql);
    }

    private function createLandPlotTableForGrid(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS grid_land_plots (
                        id serial PRIMARY KEY,
                        x INT NOT NULL,
                        y INT NOT NULL,
                        node_id INT NOT NULL,
                        child_id INT NOT NULL,
                        CONSTRAINT c_fk_node FOREIGN KEY (node_id) REFERENCES land_plots (id) ON DELETE CASCADE,
                        CONSTRAINT c_fk_child FOREIGN KEY (child_id) REFERENCES land_plots (id) ON DELETE CASCADE
                        )";
        $this->conn->exec($sql);
    }

    private function fillData(): void
    {
        $this->fillTypes();
        $this->fillLandPlotTableForTree();
    }

    private function fillTypes(): void
    {
        $types = $this->getTypes();

        foreach ($types as $type) {
            $sql = 'INSERT INTO types (name, code) VALUES(:name, :code)';
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':name', $type['name']);
            $stmt->bindValue(':code', $type['code']);
            $stmt->execute();
        }
    }

    private function fillLandPlotTableForTree(): void
    {
        $level = [];
        $level[1][0] = $this->sqlLandPlotTableForTreeInsert(NULL, 1, "Участок 1");
        $level[2][0] = $this->sqlLandPlotTableForTreeInsert($level[1][0], 2, "Участок 1.1");
        $level[2][1] = $this->sqlLandPlotTableForTreeInsert($level[1][0], 3, "Участок 1.2");
        $level[2][2] = $this->sqlLandPlotTableForTreeInsert($level[1][0], 4, "Участок 1.3");
        $level[2][3] = $this->sqlLandPlotTableForTreeInsert($level[1][0], 5, "Участок 1.4");
        $level[3][0] = $this->sqlLandPlotTableForTreeInsert($level[2][0], 6, "Участок 1.1.1");
        $level[3][1] = $this->sqlLandPlotTableForTreeInsert($level[2][0], 7, "Участок 1.1.2");
        $level[3][2] = $this->sqlLandPlotTableForTreeInsert($level[2][1], 8, "Участок 1.2.1");
        $level[3][3] = $this->sqlLandPlotTableForTreeInsert($level[2][1], 9, "Участок 1.2.2");
        $level[3][4] = $this->sqlLandPlotTableForTreeInsert($level[2][3], 10, "Участок 1.4.1");
        $level[3][5] = $this->sqlLandPlotTableForTreeInsert($level[2][3], 11, "Участок 1.4.2");

        $level = [];
        $level[1][0] = $this->sqlLandPlotTableForTreeInsert(NULL, 12, "Участок 2");
        $level[2][0] = $this->sqlLandPlotTableForTreeInsert($level[1][0], 13, "Участок 2.1");
        $level[2][1] = $this->sqlLandPlotTableForTreeInsert($level[1][0], 14, "Участок 2.2");
        $level[2][2] = $this->sqlLandPlotTableForTreeInsert($level[1][0], 15, "Участок 2.3");
        $level[2][3] = $this->sqlLandPlotTableForTreeInsert($level[1][0], 16, "Участок 2.4");
        $level[3][0] = $this->sqlLandPlotTableForTreeInsert($level[2][0], 17, "Участок 2.1.1");
        $level[3][1] = $this->sqlLandPlotTableForTreeInsert($level[2][0], 18, "Участок 2.1.2");
        $level[3][2] = $this->sqlLandPlotTableForTreeInsert($level[2][1], 19, "Участок 2.2.1");
        $level[3][3] = $this->sqlLandPlotTableForTreeInsert($level[2][1], 20, "Участок 2.2.2");
        $level[3][4] = $this->sqlLandPlotTableForTreeInsert($level[2][3], 21, "Участок 2.4.1");
        $level[3][5] = $this->sqlLandPlotTableForTreeInsert($level[2][3], 22, "Участок 2.4.2");

        $this->sqlLandPlotTableForTreeInsert(NULL, 23, "Участок 3");
        $this->sqlLandPlotTableForTreeInsert(NULL, 24, "Участок 4");
    }

    private function sqlLandPlotTableForTreeInsert(?string $parentId, int $number, string $name): bool|string
    {
        $typeId = rand(1, 3);
        $sql = 'INSERT INTO tree_land_plots (number, name, parent_id, type_id) VALUES(:number, :name, :parent_id, :type_id)';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':number', $number);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':parent_id', ($parentId === NULL) ? NULL : (int)$parentId);
        $stmt->bindValue(':type_id', $typeId);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    private function getTypes(): array
    {
        return [
            'igs' => [
                'name' => 'ИЖС',
                'code' => 'igs'
            ],
            'sh' => [
                'name' => 'С/х',
                'code' => 'sh'
            ],
            'snt' => [
                'name' => 'СНТ',
                'code' => 'snt'
            ]
        ];
    }
}
