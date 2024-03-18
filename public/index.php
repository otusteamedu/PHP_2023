<?php

use App\Jobs\ProcessRequestJob;
use App\Models\Request;
use Illuminate\Support\Facades\Queue;

$requestData = $_POST;

$request = Request::create([
    'data' => $requestData,
    'status' => Request::STATUS_PENDING
]);

Queue::push(new ProcessRequestJob($request));

echo json_encode(['request_id' => $request->id]);
