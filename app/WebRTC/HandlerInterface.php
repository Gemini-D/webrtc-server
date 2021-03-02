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

use Swoole\Http\Response;
use Swoole\WebSocket\Frame;

interface HandlerInterface
{
    public function handle(Response $response, Protocol $data, Frame $frame): void;
}
