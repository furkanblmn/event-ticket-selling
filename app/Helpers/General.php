<?php



use Carbon\Carbon;

/**
 * General Helper Functions
 * 
 * This file contains globally available helper functions
 * used throughout the application.
 */

/**
 * Format date using Carbon's isoFormat
 *
 * @param string|Carbon $date The date to format
 * @param string $format The format string (moment.js format)
 * @param string|null $displayType Optional display type modifier
 * @return string Formatted date string
 */
function formatDate(string|Carbon $date, string $format = 'DD MMMM YYYY HH:mm', ?string $displayType = null): string
{
    $parsedDate = Carbon::parse($date);

    if ($parsedDate->isToday() && $displayType !== "hour") {
        return $parsedDate->isoFormat('HH:mm') !== "00:00"
            ? 'Bugün ' . $parsedDate->isoFormat('HH:mm')
            : 'Bugün';
    }

    return $parsedDate->isoFormat($format);
}

/**
 * Format order number with leading zeros
 *
 * @param int $orderId The order ID to format
 * @param int $length Total length of the formatted number
 * @return string Formatted order number (e.g., #000123)
 */
function formatOrderNumber(int $orderId, int $length = 6): string
{
    return '#' . str_pad((string) $orderId, $length, '0', STR_PAD_LEFT);
}
