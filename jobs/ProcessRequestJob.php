<?php

namespace App\Jobs;

use App\Models\Request;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessRequestJob implements ShouldQueue
{
    protected $request;

    /**
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    /**
     * @return void
     */
    public function handle(): void
    {
        try {
            $requestData = $this->request->data;
            $this->saveRequestData($requestData);
            $this->request->updateStatus(Request::STATUS_COMPLETED);
        } catch (Exception $e) {
            $this->request->updateStatus(Request::STATUS_FAILED, $e->getMessage());
        }
    }


    /**
     * @param array $requestData
     * @return void
     */
    protected function saveRequestData(array $requestData): void
    {
        $requestDataModel = new Request();
        $requestDataModel->request_id = $this->request->id;
        $requestDataModel->data = $requestData;
        $requestDataModel->save();
    }
}