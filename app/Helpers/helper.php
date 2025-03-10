<?php

use Illuminate\Support\Carbon;

if (! function_exists('humanReadableTimestamps')) {
    function humanReadableTimestamps(string $timestamp): array
    {
        return [
            Carbon::parse($timestamp)->diffForHumans(parts: 2),
            $timestamp,
        ];
    }
}

if (! function_exists('intToDay')) {
    function intToDay(int $dayNumber): string
    {
        // Map of days to Indonesian names
        $days = [
            0 => 'Minggu',
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
        ];

        // Return the corresponding day name or null if invalid
        return $days[$dayNumber] ?? null;
    }
}
