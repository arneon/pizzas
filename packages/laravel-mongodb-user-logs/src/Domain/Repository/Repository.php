<?php

namespace Arneon\MongodbUserLogs\Domain\Repository;

interface Repository {

    public function findAll();
    public function create(array $request);
}
