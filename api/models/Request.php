<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $table = 'requests';

    protected $fillable = ['data', 'status', 'error_message'];

    const STATUS_PENDING = 'pending';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';

    /**
     *
     * @param array $requestData
     * @return Request
     */
    public static function processRequest(array $requestData): Request
    {
        $request = self::create([
            'data' => $requestData,
            'status' => self::STATUS_PENDING,
        ]);

        ProcessRequestJob::dispatch($request);

        return $request;
    }

    /**
     *
     * @param string $status
     * @param string|null $errorMessage
     * @return void
     */
    public function updateStatus(string $status, ?string $errorMessage = null): void
    {
        $this->status = $status;
        $this->error_message = $errorMessage;
        $this->save();
    }
}
