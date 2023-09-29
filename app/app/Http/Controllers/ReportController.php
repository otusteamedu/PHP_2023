<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Responses\MegaReportResponse;
use App\Jobs\MegaReportJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class ReportController extends Controller
{
    /**
     * Add request to make mega report
     *
     * @OA\Post(
     *     path="/api/v1/report/mega_report",
     *     tags={"mega_report"},
     *     operationId="/api/v1/report/mega_report",
     *     @OA\Parameter(
     *         name="data1",
     *         in="query",
     *         description="Parameter data1",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="data2",
     *         in="query",
     *         description="Parameter data2",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Returns job_status_id in data array",
     *         @OA\JsonContent(
     *          @OA\Examples(
     *              example="result",
     *              value={"errors":null, "data":{"job_status_id":123456}, "message":"success", "status":"success"},
     *              summary="some description"
     *          )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input",
     *         @OA\JsonContent(
     *          @OA\Examples(
     *              example="result",
     *              value={"errors":null, "data":null, "message":"something wrong", "status":"error"},
     *              summary="some description"
     *          )
     *         )
     *     ),
     * )
     */
    public function megaReport(Request $request): JsonResponse
    {
        try {
            $job = new MegaReportJob($request->all());
            $this->dispatch($job);
            $response = new MegaReportResponse($job->getJobStatusId());
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), $th->getCode());
        }
        return $this->successResponse($response->toArray());
    }
}
