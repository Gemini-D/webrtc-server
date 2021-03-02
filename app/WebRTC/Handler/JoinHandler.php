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
namespace App\WebRTC\Handler;

use App\WebRTC\HandlerInterface;
use App\WebRTC\Protocol;
use Han\Utils\Service;
use Swoole\Http\Response;
use Swoole\WebSocket\Frame;

class JoinHandler extends Service implements HandlerInterface
{
    public function handle(Response $response, Protocol $protocol, Frame $frame): void
    {
        $response->push($protocol->__toString());
    }
}
