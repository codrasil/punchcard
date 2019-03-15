<?php

namespace Codrasil\Punchcard;

use Carbon\CarbonInterval;

class PunchcardInterval extends CarbonInterval
{
    /**
     * Format interval to 00:00:00.
     *
     * @return string
     */
    public function toString(): string
    {
        return $this->format('%H:%I:%S');
    }

    /**
     * Alias for toString
     *
     * @return string
     */
    public function toDuration(): string
    {
        return $this->toString();
    }

    /**
     * Parse interval data into seconds.
     *
     * @return int
     */
    public function toSeconds(): int
    {
        list($hours, $minutes, $seconds) = explode(':', $this->toString());

        return ($hours * 3600) + ($minutes * 60) + $seconds;
    }
}

