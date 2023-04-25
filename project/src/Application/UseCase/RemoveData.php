<?php

declare(strict_types=1);

namespace Vp\App\Application\UseCase;

use Exception;
use Illuminate\Database\Capsule\Manager;
use Vp\App\Application\Contract\RemoveDataInterface;
use Vp\App\Application\Dto\Output\Result;
use Vp\App\Domain\Model\Task;
use Vp\App\Domain\Model\Timesheet;

class RemoveData implements RemoveDataInterface
{
    public function remove(int $id): Result
    {
        $timeSheet = $this->getTimeSheet($id);

        if (!$timeSheet) {
            return new Result(false, 'No records found for this ID.' . PHP_EOL);
        }

        $db = Manager::connection();

        try {
            $db->beginTransaction();

            $timeSheet->delete();
            $similarTimesheet = Timesheet::where('task_id', (string)$timeSheet->task_id)->first();

            if (!$similarTimesheet) {
                $task = Task::find($timeSheet->task_id);
                $task->delete();
            }

            $db->commit();

        } catch(Exception $e) {

            $db->rollBack();

            return new Result(false, 'Record deletion error: ' . $e->getMessage() . PHP_EOL);
        }

        return new Result(true, 'Timesheet id ' . $timeSheet->id . ' removed' . PHP_EOL);
    }

    private function getTimeSheet(int $id): ?Timesheet
    {
        return Timesheet::find($id);
    }
}
