<?php

namespace App\Jobs;

use App\Lib\MegaReport;

class MegaReportJob extends Job
{
    public const START_STATUS = 1;
    public const MAX_STATUS = 2;

    private array $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->prepareStatus();
        $this->queue = Queue::QUEUE_REPORT_NAME;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->setProgressMax(self::MAX_STATUS);
        $this->setProgressNow(self::START_STATUS);
        (new MegaReport($this->data))->make();
        $this->setProgressNow(self::MAX_STATUS);
    }
}
