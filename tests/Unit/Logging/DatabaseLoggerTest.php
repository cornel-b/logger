<?php

namespace Tests\Unit\Logging;

use App\Logging\DatabaseLogger;
use App\Logging\DatabaseLogHandler;
use Monolog\Logger;
use Tests\TestCase;

class DatabaseLoggerTest extends TestCase
{
    public function it_creates_a_logger_with_database_handler()
    {
        $logger = (new DatabaseLogger)([]);

        expect($logger)->toBeInstanceOf(Logger::class)
            ->and($logger->getName())->toBe('database')
            ->and($logger->getHandlers()[0])->toBeInstanceOf(DatabaseLogHandler::class);
    }
}
