<?php

namespace App\Logging;

use Illuminate\Log\Logger;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\HandlerInterface;
use Monolog\Logger as MonologLogger;

class CustomizeFormatter
{
    public function __invoke(Logger $logger): void
    {
        $monolog = method_exists($logger, 'getLogger')
            ? $logger->getLogger()
            : ($logger instanceof MonologLogger ? $logger : null);

        if (!$monolog) {
            return;
        }

        $output = "[%datetime%] %level_name%: %message% %context%\n";
        $formatter = new LineFormatter($output, 'Y-m-d H:i:s', true, true);

        if (method_exists($monolog, 'getHandlers')) {
            foreach ($monolog->getHandlers() as $handler) {
                if ($handler instanceof HandlerInterface && method_exists($handler, 'setFormatter')) {
                    try {
                        $handler->setFormatter($formatter);
                    } catch (\Throwable $e) {
                    }
                }
            }
        }
    }
}
