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

use Hyperf\Redis\Redis;
use Xin\RedisCollection\SetCollection;

class Room extends SetCollection
{
    protected $prefix = 'room:';

    protected $ttl = 3600 * 24;

    protected $exist = true;

    public function reload($parentId): array
    {
        return [];
    }

    public function redis()
    {
        return di()->get(Redis::class);
    }

    public function join(int $roomId, int $fd)
    {
        $id = static::toID($fd);

        return $this->add($roomId, $id);
    }

    public static function toID(int $fd): string
    {
        return di()->get(Node::class)->getId() . ':' . $fd;
    }
}
