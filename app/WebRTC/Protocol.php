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

use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use Hyperf\Utils\Codec\Json;
use Hyperf\Utils\Contracts\Arrayable;
use Hyperf\Utils\Contracts\Jsonable;

class Protocol implements Arrayable, Jsonable
{
    const ERROR = 'error';

    const ALERT = 'alert';

    const REPLY = 'reply';

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

    /**
     * @var null|int|string
     */
    protected $id;

    public function __construct(string $protocol, $data, $id)
    {
        $this->protocol = $protocol;
        $this->data = $data;
        $this->id = $id;
    }

    public function __toString(): string
    {
        return Json::encode($this->toArray());
    }

    public static function make($data): Protocol
    {
        if (! is_array($data) || empty($data['protocol'])) {
            throw new BusinessException(ErrorCode::PROTOCOL_INVALID);
        }

        return new Protocol((string) $data['protocol'], $data['data'] ?? null, $data['id'] ?? null);
    }

    public function toArray(): array
    {
        return [
            'protocol' => $this->protocol,
            'id' => $this->id,
            'data' => $this->data,
        ];
    }

    public function getProtocol(): string
    {
        return $this->protocol;
    }

    public function setProtocol(string $protocol)
    {
        $this->protocol = $protocol;
        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }
}
