<?php

namespace Arneon\MongodbUserLogs\Domain\Entity;

class Log
{
    private string $level;
    private string $message;
    private string $context;
    private \DateTime $createdAt;

    public function __construct(
        string $level,
        string $message,
        string $context)
    {
        $this->level = $level;
        $this->message = $message;
        $this->context = $context;
        $this->createdAt = new \DateTime();
    }

    public function toArray(): array
    {
        return [
            'level' => $this->level,
            'message' => $this->message,
            'context' => $this->context,
            'created_at' => $this->createdAt->format('Y-m-d H:i:s'),
        ];
    }
}
