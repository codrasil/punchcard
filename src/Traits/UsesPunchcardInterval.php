<?php

namespace Codrasil\Punchcard\Traits;

use Carbon\Carbon;
use Codrasil\Punchcard\PunchcardInterval;

trait UsesPunchcardInterval
{
    /**
     * The PunchcardInterval instance.
     *
     * @return \Codrasil\Punchcard\PunchcardInterval
     */
    public function interval()
    {
        return new PunchcardInterval;
    }
}
