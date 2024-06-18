<?php

namespace SebKay\WPCronable;

class Helpers
{
    public static function wpCronIntervals(): array
    {
        return [
            [
                'slug' => 'five_minutes',
                'label' => \__('5 minutes', 'wp-cronable'),
                'value' => 300,
            ],
            [
                'slug' => 'ten_minutes',
                'label' => \__('10 minutes', 'wp-cronable'),
                'value' => 600,
            ],
            [
                'slug' => 'fifteen_minutes',
                'label' => \__('15 minutes', 'wp-cronable'),
                'value' => 900,
            ],
            [
                'slug' => 'twenty_minutes',
                'label' => \__('20 minutes', 'wp-cronable'),
                'value' => 1200,
            ],
            [
                'slug' => 'thirty_minutes',
                'label' => \__('30 minutes', 'wp-cronable'),
                'value' => 1800,
            ],
            [
                'slug' => 'forty_five_minutes',
                'label' => \__('45 minutes', 'wp-cronable'),
                'value' => 2700,
            ],
            [
                'slug' => 'one_hour',
                'label' => \__('1 hour', 'wp-cronable'),
                'value' => 3600,
            ],
            [
                'slug' => 'four_hours',
                'label' => \__('4 hours', 'wp-cronable'),
                'value' => 14400,
            ],
            [
                'slug' => 'daily',
                'label' => \__('1 day', 'wp-cronable'),
                'value' => 86400,
            ],
        ];
    }

    /**
     * Get one of the cron intervals by it's time
     * * Filter the array to find a row with the specified time.
     * * Then re-index the array keys.
     * * Then return the first result (as there should only be one anyway).
     */
    public static function getCronScheduleByTime(int $time): ?array
    {
        return \collect(self::wpCronIntervals())
            ->filter(function ($interval) use ($time) {
                return $interval['value'] == $time;
            })
            ->values()
            ->first();
    }
}
