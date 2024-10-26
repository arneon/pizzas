<?php

namespace Arneon\MongodbUserLogs\Infrastructure\Model;

use MongoDB\Laravel\Eloquent\Model as EloquentModel;

class Model extends EloquentModel
{
    protected $connection;
    protected $database;
    protected $table;
    protected $fillable;

    public function __construct()
    {
        $this->connection = config('arneon-mongodb-user-logs.connection.connection');
        $this->database = config('arneon-mongodb-user-logs.connection.database');
        $this->table = config('arneon-mongodb-user-logs.table', 'user_logs');
        $this->fillable = config('arneon-mongodb-user-logs.fillable', '*');
    }
}
