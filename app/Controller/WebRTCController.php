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
namespace App\Controller;

use App\WebRTC\ExceptionHandler;
use App\WebRTC\HandlerInterface;
use App\WebRTC\Protocol;
use Hyperf\Contract\OnCloseInterface;
use Hyperf\Contract\OnMessageInterface;
use Hyperf\Contract\OnOpenInterface;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Utils\Codec\Json;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\WebSocket\Frame;

class WebRTCController extends Controller implements OnOpenInterface, OnMessageInterface, OnCloseInterface
{
    /**
     * @Inject
     * @var ExceptionHandler
     */
    protected $exception;

    /**
     * @Inject
     * @var StdoutLoggerInterface
     */
    protected $logger;

    /**
     * @param Response $server
     */
    public function onClose($server, int $fd, int $reactorId): void
    {
        try {
        } catch (\Throwable $exception) {
            $server->push((string) $this->exception->handle($exception));
        }
    }

    /**
     * @param Response $server
     */
    public function onMessage($server, Frame $frame): void
    {
        try {
            $protocol = Protocol::make(Json::decode($frame->data));
            $name = sprintf('WebRTC.%s', $protocol->getProtocol());
            if (! $this->container->has($name)) {
                return;
            }

            $handler = $this->container->get($name);
            if (! $handler instanceof HandlerInterface) {
                return;
            }

            $handler->handle($server, $protocol, $frame);
        } catch (\Throwable $exception) {
            $server->push((string) $this->exception->handle($exception, $protocol ?? null));
        }
    }

    /**
     * @param Response $server
     */
    public function onOpen($server, Request $request): void
    {
        try {
            $this->logger->info(Json::encode([
                'fd' => $request->fd,
                'header' => $request->header,
                'server' => $request->server,
            ]));
        } catch (\Throwable $exception) {
            $server->push((string) $this->exception->handle($exception));
        }
    }
}
