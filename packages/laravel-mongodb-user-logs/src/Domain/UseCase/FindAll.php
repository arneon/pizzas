<?php

namespace Arneon\MongodbUserLogs\Domain\UseCase;

interface FindAll
{
    public function __invoke(): array;
}
