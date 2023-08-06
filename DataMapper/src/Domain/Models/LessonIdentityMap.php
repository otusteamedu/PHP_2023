<?php

declare(strict_types=1);

namespace Art\DataMapper\Domain\Models;

class LessonIdentityMap
{
    /**
     * @var array
     */
    private static array $lessons = [];

    /**
     * @param int $id
     * @return Lesson|null
     */
    public static function getLesson(int $id): ?Lesson
    {
        return self::$lessons[$id] ?? null;
    }

    /**
     * @param Lesson $lesson
     * @return void
     */
    public static function addLesson(Lesson $lesson): void
    {
        self::$lessons[$lesson->id] = $lesson;
    }

    /**
     * @return array
     */
    public static function getAllLessons(): array
    {
        return self::$lessons;
    }
}