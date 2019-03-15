<?php

namespace Codrasil\Punchcard\Traits;

use Carbon\Carbon;

trait UsesCarbon
{
    /**
     * The \Carbon\Carbon instance.
     *
     * @return \Carbon\Carbon
     */
    public function carbon()
    {
        return new Carbon;
    }

    /**
     * Shorthand for Carbon::parse
     *
     * @param string $date
     * @return \Carbon\Carbon
     */
    public function parse($date)
    {
        return $this->carbon()->parse($date);
    }
}
