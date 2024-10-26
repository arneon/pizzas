<?php

namespace Arneon\MongodbUserLogs\Domain\UseCase;

interface Create
{
    public function __invoke(array $request): array;
}
