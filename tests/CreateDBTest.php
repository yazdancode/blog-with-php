<?php

use Database\CreateDB;
use PHPUnit\Framework\TestCase;

class CreateDBTest extends TestCase
{
    public function testInitializeDatabaseCallsCreateTable(): void
    {
        $mock = $this->getMockBuilder(CreateDB::class)
            ->onlyMethods(['connect', 'createTable'])
            ->getMock();
        $mock->expects($this->once())
            ->method('connect');
        $mock->expects($this->exactly(6))
        ->method('createTable');
        $mock->initializeDatabase();
    }
}
