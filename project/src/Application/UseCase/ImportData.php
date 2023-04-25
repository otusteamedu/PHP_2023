<?php

declare(strict_types=1);

namespace Vp\App\Application\UseCase;

use Throwable;
use Vp\App\Domain\Model\Employee;
use Vp\App\Domain\Model\Position;
use Vp\App\Domain\Model\Task;
use Vp\App\Domain\Model\Timesheet;
use Vp\App\Infrastructure\Console\Result\Result;
use Vp\App\Infrastructure\Exception\MethodNotFound;

class ImportData
{
    private FileStorage $fileStorage;

    private array $errors = [];

    public function __construct(FileStorage $fileStorage)
    {
        $this->fileStorage = $fileStorage;
    }

    /**
     * @throws MethodNotFound
     */
    public function import(string $fileName, string $context): Result
    {
        $methodName = __FUNCTION__ . ucfirst($context);

        if (!method_exists($this, $methodName )) {
            throw new MethodNotFound('Method not found');
        }

        $path = $this->fileStorage->getPathFile($fileName);

        if ($path === null) {
            return new Result(false, 'File not found' . PHP_EOL);
        }

        $resource = $this->createResource($path);

        if ($resource === null) {
            return new Result(false, 'Failed to open file ' . $fileName . PHP_EOL);
        }

        $number = $correct = $inCorrect = 0;

        while (($data = fgetcsv($resource, 1000)) !== false) {
            $number++;
            $result = $this->{$methodName}($data, $number);
            $result ? $correct++ : $inCorrect++;
        }

        $this->closeResource($resource);

        $message = $this->generateErrorMessage();
        $message = $this->getResultMessage($correct, $context, $message, $inCorrect);

        return new Result(true, $message);
    }

    private function importPositions(array $data, int $number): bool
    {
        $position = new Position();
        $position->name = $data[0];
        $position->rate = (int)$data[1];

        try {
            return $position->saveOrFail();
        } catch (Throwable $throwable) {
            $this->errors[$number] = $throwable->getMessage();
            return false;
        }
    }

    private function importEmployees(array $data, int $number): bool
    {
        $position = Position::where('name', trim($data[1]))->first();

        if (!$position) {
            return false;
        }

        $employee = new Employee();
        $employee->name = $data[0];
        $employee->position_id = $position->id;

        try {
            return $employee->saveOrFail();
        } catch (Throwable $throwable) {
            $this->errors[$number] = $throwable->getMessage();
            return false;
        }
    }

    private function importTimesheet(array $data, int $number): bool
    {
        $task = $this->getTaskByTitle(trim($data[0]));
        $employee = $this->getEmployeeByName(trim($data[1]));

        if (!$task || !$employee) {
            return false;
        }

        $timesheet = new Timesheet();
        $timesheet->task_id = $task->id;
        $timesheet->employee_id = $employee->id;
        $timesheet->start_time = $data[2];
        $timesheet->end_time = $data[3];

        try {
            return $timesheet->saveOrFail();
        } catch (Throwable $throwable) {
            $this->errors[$number] = $throwable->getMessage();
            return false;
        }

    }

    public function importDefault(): Result
    {
        return new Result(false, 'The file name is incorrect' . PHP_EOL);
    }

    private function generateErrorMessage(): string
    {
        $message = PHP_EOL;

        if (count($this->errors) > 0) {
            $message .= 'WARNING! Errors occurred while adding some records. The following is the sequence number of the record in the file and the error:' . PHP_EOL . PHP_EOL;
        }

        foreach ($this->errors as $number => $error) {
            $message .= $number . '. ' . $error . PHP_EOL . PHP_EOL;
        }

        return $message;
    }

    private function createResource(string $path)
    {
        $handle = fopen($path, "r");
        return ($handle !== false) ? $handle : null;
    }

    private function closeResource($resource): void
    {
        fclose($resource);
    }

    private function getTaskByTitle(string $title): Task|bool
    {
        $task = Task::where('title', $title)->first();

        if (!$task) {
            $task = $this->createTask($title);
        }

        return $task;
    }

    private function getEmployeeByName(string $name): ?Employee
    {
        return Employee::where('name', $name)->first();
    }

    private function createTask(string $title): bool|Task
    {
        $task = new Task();
        $task->title = $title;

        try {

            $task->saveOrFail();
            return $task;

        } catch (Throwable) {
            return false;
        }
    }

    private function getResultMessage(int $correct, string $context, string $message, int $inCorrect): string
    {
        $message .= 'Imported ' . $correct . ' ' . $context . PHP_EOL;

        if ($inCorrect > 0) {
            $message .= 'Incorrect: ' . $inCorrect . PHP_EOL;
        }

        $message .= PHP_EOL;
        return $message;
    }
}
