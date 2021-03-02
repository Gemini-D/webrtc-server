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

use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use App\WebRTC\HandlerInterface;
use App\WebRTC\Protocol;
use App\WebRTC\Room;
use Han\Utils\Service;
use Swoole\Http\Response;
use Swoole\WebSocket\Frame;

class JoinHandler extends Service implements HandlerInterface
{
    public function handle(Response $response, Protocol $protocol, Frame $frame): void
    {
        $data = $protocol->getData();
        if (is_array($data) && $roomId = intval($data['room_id'] ?? 0)) {
            if ($roomId > 0) {
                di()->get(Room::class)->join($roomId, $response->fd);
                $response->push((string) new Protocol(
                    Protocol::REPLY,
                    [
                        'code' => 0,
                    ],
                    $protocol->getId()
                ));
                return;
            }
        }

        throw new BusinessException(ErrorCode::ROOM_NOT_EXISTS);
    }
}
