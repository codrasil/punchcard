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

    public static function providerTardyTimeData()
    {
        return [
            [
                ['time_in' => '08:48:00', 'pm_time_in' => '13:04:00'],
                ['default_time_in' => '08:00:00'],
                ['total_tardy' => '00:48:00', 'total_tardy_PM' => '00:04:00'],
            ],
            [
                ['time_in' => '08:48:00', 'pm_time_in' => '13:55:00'],
                ['default_time_in' => '09:00:00', 'default_lunch_end' => '14:00:00'],
                ['total_tardy' => '00:00:00', 'total_tardy_PM' => '00:00:00'],
            ],
            [
                ['time_in' => '09:15:20', 'pm_time_in' => '14:15:00'],
                ['default_time_in' => '09:00:00', 'default_lunch_end' => '14:00:00'],
                ['total_tardy' => '00:15:20', 'total_tardy_PM' => '00:15:00'],
            ],
        ];
    }

    public static function providerOvertimeData()
    {
        return [
            [
                ['time_out' => '6:20 PM'],
                ['default_time_out' => '5 PM'],
                ['total_overtime' => '01:20:00'],
            ],
            [
                ['time_out' => '6:00 PM'],
                ['default_time_out' => '6 PM'],
                ['total_overtime' => '00:00:00'],
            ],
            [
                ['time_out' => '6:00:01 PM'],
                ['default_time_out' => '6 PM'],
                ['total_overtime' => '00:00:01'],
            ],
            [
                ['time_out' => '5:00 PM'],
                ['default_time_out' => '6 PM'],
                ['total_overtime' => '00:00:00'],
            ],
        ];
    }

    public static function providerUndertimeData()
    {
        return [
            [
                ['time_out' => '4:20 PM'],
                ['default_lunch_start' => '12:00 PM', 'default_time_out' => '5 PM'],
                ['total_undertime' => '00:40:00', 'total_undertime_AM' => '00:00:00'],
            ],
            [
                ['time_out' => '6:00 PM'],
                ['default_lunch_start' => '12:00 PM', 'default_time_out' => '6 PM'],
                ['total_undertime' => '00:00:00', 'total_undertime_AM' => '00:00:00'],
            ],
            [
                ['time_out' => '6:00:01 PM'],
                ['default_lunch_start' => '12:00 PM', 'default_time_out' => '6 PM'],
                ['total_undertime' => '00:00:00', 'total_undertime_AM' => '00:00:00'],
            ],
            [
                ['time_out' => '3:00 PM'],
                ['default_lunch_start' => '12:00 PM', 'default_time_out' => '6 PM'],
                ['total_undertime' => '03:00:00', 'total_undertime_AM' => '00:00:00'],
            ],
            [
                ['time_out' => '11:00 AM'],
                ['default_lunch_start' => '12:00 PM', 'default_time_out' => '6 PM'],
                ['total_undertime' => '06:00:00', 'total_undertime_AM' => '01:00:00'],
            ],
            [
                ['time_out' => '12:00 PM'],
                ['default_lunch_start' => '12:00 PM', 'default_time_out' => '5 PM'],
                ['total_undertime' => '04:00:00', 'total_undertime_AM' => '00:00:00'],
            ],
        ];
    }
}
