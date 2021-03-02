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

use Hyperf\Utils\Codec\Json;
use Hyperf\Utils\Contracts\Arrayable;
use Hyperf\Utils\Contracts\Jsonable;

class Protocol implements Arrayable, Jsonable
{
    const ERROR = 'error';

    const ALERT = 'alert';

    const JOIN_ROOM = 'join';

    const CLIENT_CALL = 'client.call';

    const CLIENT_ANSWER = 'client.answer';

    const CLIENT_OFFER = 'client.offer';

    /**
     * @var string
     */
    protected $protocol;

    /**
     * @var mixed
     */
    protected $data;

    public function __construct(string $protocol, $data)
    {
        $this->protocol = $protocol;
        $this->data = $data;
    }

    public function __toString(): string
    {
        return Json::encode([
            'protocol' => $this->protocol,
            'data' => $this->data,
        ]);
    }

    public function toArray(): array
    {
    }
}
