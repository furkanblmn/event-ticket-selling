<?php

namespace App\Logging;

use Illuminate\Support\Facades\Log;
use Throwable;

class AppLogger
{
    public static function info(string $message, array $context = []): void
    {
        Log::channel(self::resolveChannel($context))->info($message, self::withDefaults($context));
    }

    public static function warning(string $message, array $context = []): void
    {
        Log::channel(self::resolveChannel($context))->warning($message, self::withDefaults($context));
    }

    public static function error(string $message, Throwable|string $error = null, array $context = []): void
    {
        if ($error instanceof Throwable) {
            $context = array_merge($context, [
                'exception' => get_class($error),
                'error_message' => $error->getMessage(),
                'file' => $error->getFile(),
                'line' => $error->getLine(),
                'code' => $error->getCode(),
            ]);
        } elseif (is_string($error)) {
            $context = array_merge($context, ['error_message' => $error]);
        }

        Log::channel(self::resolveChannel($context))->error($message, self::withDefaults($context));
    }

    private static function withDefaults(array $context): array
    {
        return array_merge([
            'timestamp' => now()->toDateTimeString(),
            'environment' => config('app.env'),
        ], $context);
    }

    private static function resolveChannel(array $context): string
    {
        return $context['channel'] ?? 'dev';
    }
}
