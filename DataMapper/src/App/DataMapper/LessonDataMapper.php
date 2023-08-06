<?php

declare(strict_types=1);

namespace Art\DataMapper\App\DataMapper;

use Art\DataMapper\Domain\Models\Lesson;
use Art\DataMapper\Domain\Models\LessonCollection;
use Art\DataMapper\Domain\Models\LessonIdentityMap;
use PDO;

class LessonDataMapper extends DataMapperPrototype
{
    /**
     * @return string
     */
    public static function getTableName(): string
    {
        return 'lesson';
    }

    /**
     * @param PDO $connection
     */
    public function __construct(PDO $connection)
    {
        parent::__construct($connection);

        $this->selectStatement = $connection->prepare(
            sprintf('select * from %s where id = ?', self::getTableName())
        );

        $this->insertStatement = $connection->prepare(
            sprintf('insert into %s (name) values (?)', self::getTableName())
        );

        $this->updateStatement = $connection->prepare(
            sprintf('update %s set name = ? where id = ?', self::getTableName())
        );

        $this->deleteStatement = $connection->prepare(
            sprintf('delete from %s where id = ?', self::getTableName())
        );

        $this->findAllStatement = $connection->prepare(
            sprintf('select * from %s', self::getTableName())
        );
    }

    /**
     * @return LessonCollection|LessonIdentityMap
     */
    public function findAll(): LessonCollection | LessonIdentityMap
    {
        // use Identity Map
        $lessons = LessonIdentityMap::getAllLessons();

        if ($lessons !== []) {
            return $lessons;
        }
        //

        $this->findAllStatement->execute();

        $collection = new LessonCollection();

        foreach ($this->findAllStatement->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $collection->add(new Lesson(
                $row['id'],
                $row['name']
            ));

            LessonIdentityMap::addLesson($row);
        }

        return $collection;
    }

    /**
     * @param Lesson $lesson
     * @return bool
     */
    public function update(Lesson $lesson): bool
    {
        return $this->updateStatement->execute([
            $lesson->getName(),
            $lesson->getId()
        ]);
    }

    /**
     * @param Lesson $lesson
     * @return Lesson|null
     */
    public function insert(Lesson $lesson): ?Lesson
    {
        if (!$this->insertStatement->execute([
            $lesson->getName()
        ])) {
            return null;
        }

        return $lesson->setId((int) $this->pdo->lastInsertId());
    }

    /**
     * @param Lesson $lesson
     * @return bool
     */
    public function delete(Lesson $lesson): bool
    {
        return $this->deleteStatement->execute([$lesson->getId()]);
    }
}