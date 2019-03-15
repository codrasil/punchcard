<?php

namespace Codrasil\Punchcard\Test\DataProvider;

class PunchcardDataProvider
{
    /** dataProvider */
    public static function providerTimeData()
    {
        return [
            [
                ['time_in' => '08:00:00', 'time_out' => '17:00:00'],
                ['default_lunch_start' => '12:00:00', 'default_lunch_end' => '13:00:00'],
                ['total_AM' => '04:00:00', 'total_PM' => '04:00:00', 'total_duration' => '08:00:00', 'total_duration_without_lunch' => '09:00:00', 'total_duration_in_seconds' => 28800],
            ],
            [
                ['time_in' => '09:27:00', 'time_out' => '13:21:00'],
                ['default_lunch_start' => '12:00 PM', 'default_lunch_end' => '13:00:00'],
                ['total_AM' => '02:33:00', 'total_PM' => '00:21:00', 'total_duration' => '02:54:00', 'total_duration_without_lunch' => '03:54:00', 'total_duration_in_seconds' => 10440],
            ],
            [
                ['time_in' => '13:00:00', 'time_out' => '17:00:00'],
                ['default_lunch_start' => '12:00 PM', 'default_lunch_end' => '13:00:00'],
                ['total_AM' => '00:00:00', 'total_PM' => '04:00:00', 'total_duration' => '04:00:00', 'total_duration_without_lunch' => '04:00:00', 'total_duration_in_seconds' => 14400],
            ],
            [
                ['time_in' => '08:00 AM', 'time_out' => '11 AM'],
                ['default_lunch_start' => '12:00 PM', 'default_lunch_end' => '13:00:00'],
                ['total_AM' => '03:00:00', 'total_PM' => '00:00:00', 'total_duration' => '03:00:00', 'total_duration_without_lunch' => '03:00:00', 'total_duration_in_seconds' => 10800],
            ],
        ];
    }
}
