<?php

namespace Codrasil\Punchcard\Traits;

trait LuncheonHourAware
{
    protected $includeLuncheonHour = true;

    /**
     * Set lunch usage.
     *
     * @param boolean $using
     * @return void
     */
    public function lunch($using = true)
    {
        $this->includeLuncheonHour = $using;
    }

    /**
     * Check if lunch is set to true.
     *
     * @return boolean
     */
    public function includeLuncheonHour()
    {
        return $this->includeLuncheonHour;
    }

    /**
     * Set the lunchStart variable.
     *
     * @param string $lunchStart
     */
    public function setLunchStart($lunchStart)
    {
        $this->params['default_lunch_start'] = $this->parse($lunchStart);

        return $this;
    }

    /**
     * Set the lunchEnd variable.
     *
     * @param string $lunchEnd
     */
    public function setLunchEnd($lunchEnd)
    {
        $this->params['default_lunch_end'] = $this->parse($lunchEnd);

        return $this;
    }

    /**
     * Retrieve the lunchStart value.
     *
     * @return \Carbon\Carbon
     */
    public function lunchStart()
    {
        return $this->getParam('default_lunch_start');
    }

    /**
     * Retrieve the lunchEnd value.
     *
     * @return \Carbon\Carbon
     */
    public function lunchEnd()
    {
        return $this->getParam('default_lunch_end');
    }

    /**
     * Calculate total lunch hours.
     *
     * @return string
     */
    protected function getTotalLunchHours()
    {
        return $this->parse(
            $this->parseTime(
                $this->parseSeconds($this->lunchEnd()) - $this->parseSeconds($this->lunchStart())
            )
        );
    }

    /**
     * Check if the given time is before lunch hour
     *
     * @param \Carbon\Carbon $time
     * @return boolean
     */
    protected function isBeforeLunch($time)
    {
        return $time->lessThanOrEqualTo($this->lunchStart());
    }

    /**
     * Check if the given time is after lunch hour
     *
     * @param \Carbon\Carbon $time
     * @return boolean
     */
    protected function isAfterLunch($time)
    {
        return $time->greaterThanOrEqualTo($this->lunchEnd());
    }
}
