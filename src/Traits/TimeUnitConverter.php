<?php

namespace Codrasil\Punchcard\Traits;

trait TimeUnitConverter
{
    /**
     * Convert the property $total to seconds.
     *
     * @return int
     */
    public function toSeconds(): int
    {
        return $this->parseSeconds($this->toString());
    }

    /**
     * Converts the string to time.
     * Expects $total to be
     * instance of DateTime
     *
     * @param  string $seconds
     * @return string
     */
    public function toString()
    {
        return $this->total()->format('%H:%I:%S');
    }

    /**
     * Converts the string to seconds.
     *
     * @param string $time
     * @return string
     */
    protected function parseSeconds(string $time)
    {
        list($hours, $minutes, $seconds) = explode(':', date('H:i:s', strtotime($time)));

        $hours = $hours * self::DEFAULT_HOURS_IN_SECONDS;
        $minutes = $minutes * self::DEFAULT_MINUTES_IN_SECONDS;

        return $hours + $minutes + $seconds;
    }

    /**
     * Converts the string to time.
     *
     * @param  string $seconds
     * @return string
     */
    protected function parseTime($seconds = null)
    {
        $hours = floor((int) $seconds / self::DEFAULT_HOURS_IN_SECONDS);
        $minutes = floor((int) $seconds / self::DEFAULT_MINUTES_IN_SECONDS % self::DEFAULT_SECONDS_IN_SECONDS);
        $seconds = floor((int) $seconds % self::DEFAULT_SECONDS_IN_SECONDS);

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }
}
