<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Responses\JobStatusResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Imtigger\LaravelJobStatus\JobStatus;
use OpenApi\Annotations as OA;

class ServiceController extends Controller
{
    /**
     * Check status of job
     *
     * @OA\Get(
     *     path="/api/v1/check_job_status?id={id}",
     *     tags={"check_job_status"},
     *     operationId="/api/v1/check_job_status?id={id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Parameter id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Returns status of job",
     *         @OA\JsonContent(
     *          @OA\Examples(
     *              example="result",
     *              value={"errors":null, "data":{"status":"queued"}, "message":"success", "status":"success"},
     *              summary="some description"
     *          ),
     *          @OA\Examples(
     *              example="result2",
     *              value={"errors":null, "data":{"status":"executing"}, "message":"success", "status":"success"},
     *              summary="some description"
     *          ),
     *          @OA\Examples(
     *              example="result3",
     *              value={"errors":null, "data":{"status":"finished"}, "message":"success", "status":"success"},
     *              summary="some description"
     *          ),
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input",
     *         @OA\JsonContent(
     *          @OA\Examples(
     *              example="result",
     *              value={"errors":null, "data":null, "message":"not found", "status":"error"},
     *              summary="some description"
     *          )
     *         )
     *     ),
     * )
     */
    public function checkJobStatus(Request $request): JsonResponse
    {
        try {
            $job = JobStatus::find($request->get('id'));
            if (!$job) {
                return $this->errorResponse(static::STATUS_MESSAGE_404, static::STATUS_404);
            }
            $response = JobStatusResponse::fromArray($job->getAttributes());
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), $th->getCode());
        }
        return $this->successResponse($response->toArray());
    }
}
