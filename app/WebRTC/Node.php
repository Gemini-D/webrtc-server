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

class Node
{
    /**
     * @var string
     */
    protected $id;

    public function __construct()
    {
        $this->id = uniqid();
    }

    public function getId(): string
    {
        return $this->id;
    }
}
