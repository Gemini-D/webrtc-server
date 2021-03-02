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
use Hyperf\Contract\StdoutLoggerInterface;
use Throwable;

class ExceptionHandler
{
    /**
     * @var StdoutLoggerInterface
     */
    protected $logger;

    public function __construct(StdoutLoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function handle(Throwable $throwable): Protocol
    {
        $code = 500;
        $message = 'Server Error';

        switch (true) {
            case $throwable instanceof BusinessException:
                $code = $throwable->getCode();
                $message = $throwable->getMessage();
                $this->logger->warning((string) $throwable);
                break;
            default:
                $this->logger->error((string) $throwable);
                break;
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
