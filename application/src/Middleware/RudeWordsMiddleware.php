<?php

declare(strict_types=1);

namespace Gesparo\HW\Middleware;

use Gesparo\HW\App\AppException;
use Symfony\Component\HttpFoundation\Request;

class RudeWordsMiddleware extends BaseMiddleware
{
    private const STOP_WORDS = [
        'word1',
        'word2',
        'word3',
    ];

    /**
     * @throws AppException
     */
    public function handle(Request $request)
    {
        if ($request->get('message') !== null) {
            $message = $request->get('message');

            foreach (self::STOP_WORDS as $word) {
                if (stripos($message, $word) !== false) {
                    throw AppException::messageHasStopWords($message, $word);
                }
            }
        }

        return parent::handle($request);
    }
}
