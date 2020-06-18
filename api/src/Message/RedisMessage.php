<?php
namespace App\Message;

class RedisMessage
{
    private ?string $content;
    private ?int $id;

    public function __construct(string $content, int $id)
    {
        $this->content = $content;
        $this->id = $id;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getId(): int
    {
        return $this->id;
    }
}