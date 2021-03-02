<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace App\WebRTC;

use App\Exception\BusinessException;
use Throwable;

class ExceptionHandler
{
    public function handle(Throwable $throwable): Protocol
    {
        $code = 500;
        $message = 'Server Error';

        if ($throwable instanceof BusinessException) {
            $code = $throwable->getCode();
            $message = $throwable->getMessage();
        }

        return new Protocol(
            Protocol::ERROR,
            [
                'code' => $code,
                'message' => $message,
            ]
        );
    }
}
