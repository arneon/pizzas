<?php

namespace Arneon\MongodbUserLogs\Tests\Feature;

use Arneon\MongodbUserLogs\Tests\TestCase;
use Arneon\MongodbUserLogs\Infrastructure\Controller\MongodbLogController as Controller;
use Illuminate\Http\Request;

class MongodbLogTest extends TestCase
{
    public function test_attempt_to_create_log_with_bad_level_field()
    {
        $controller = app(Controller::class);
        $array = [
            ['level' => 123],
            ['level' => ''],
            ['level' => '12'],
            ['level' => '1234567890123456789012345678901234567890'],
        ];
        foreach ($array as $item) {
            $item['message'] = 'test message';
            $request = new Request($item);
            $createResponse = $controller->create($request);
            $errorResponse = json_decode($createResponse->getContent(), true);
            $this->assertNotEmpty($errorResponse);
            $this->assertArrayHasKey('errors', $errorResponse);
        }

    }
    public function test_attempt_to_create_log_with_bad_message_field()
    {
        $controller = app(Controller::class);
        $array = [
            ['message' => 1234567890],
            ['message' => ''],
            ['message' => '123456789'],
        ];
        foreach ($array as $item) {
            $item['level'] = 'test';
            $request = new Request($item);
            $createResponse = $controller->create($request);
            $errorResponse = json_decode($createResponse->getContent(), true);
            $this->assertNotEmpty($errorResponse);
            $this->assertArrayHasKey('errors', $errorResponse);
        }
    }

    public function test_create_log_with_good_request()
    {
        $fieldsArray = ['id', 'level', 'message'];

        $goodRequest = new Request(['message' => 'Test message', 'level' => 'test']);

        $controller = app(Controller::class);

        $createResponse = $controller->create($goodRequest);
        $newLog = json_decode($createResponse->getContent(), true);

        $getAllResponse = $controller->findAll();
        $getAllArray = json_decode($getAllResponse->getContent(), true);

        $this->assertNotEmpty($getAllResponse);

        foreach($fieldsArray as $field) {
            $this->assertEquals($newLog['data'][$field], $getAllArray['data'][(sizeof($getAllArray['data']) - 1)][$field]);
        }
    }

}
