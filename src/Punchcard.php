<?php

namespace Codrasil\Punchcard;

use DateTime;

class Punchcard
{
    use Traits\LuncheonHourAware,
        Traits\UsesCarbon,
        Traits\TimeUnitConverter;

    /**
     * The default hours in seconds.
     * Calculation: n*60*60
     *
     */
    public const DEFAULT_HOURS_IN_SECONDS = 3600;

    /**
     * The default minutes in seconds.
     * Calculation: 1*60*n
     *
     */
    public const DEFAULT_MINUTES_IN_SECONDS = 60;

    /**
     * The default seconds in seconds.
     * Calculation: 60
     *
     */
    public const DEFAULT_SECONDS_IN_SECONDS = 60;

    /**
     * The default parameters for times in a day.
     *
     * @var array
     */
    protected $params = [
        'default_time_in' => '08:00:00',
        'default_time_out' => '17:00:00',
        'default_lunch_start' => '12:00:00',
        'default_lunch_end' => '13:00:00',
    ];

    /**
     * The current total value of any current method called.
     *
     * @var mixed
     */
    protected $total;

    /**
     * The current time in variable
     *
     * @var string
     */
    protected $timeIn;

    /**
     * The current time in variable
     *
     * @var string
     */
    protected $timeOut;

    /**
     * The Constructor of the class to
     * initialize variables.
     *
     * @param  array $params
     */
    public function __construct(array $params = null)
    {
        $this->setParams($params ?? []);
    }

    /**
     * Set parameters.
     *
     * @param array $params
     */
    public function setParams(array $params)
    {
        $this->params = array_map(function ($param) {
            return $this->parse($param);
        }, array_merge($this->params, $params));

        return $this;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * Retrieve a given parameter's value.
     *
     * @return mixed
     */
    public function getParam($key)
    {
        return $this->params[$key] ?? null;
    }

    /**
     * Set the timein variable.
     *
     * @param string $timeIn
     */
    public function setTimeIn($timeIn)
    {
        $this->timeIn = $this->parse($timeIn);

        return $this;
    }

    /**
     * Retrieve the timeIn value.
     *
     * @return \Carbon\Carbon
     */
    public function timeIn()
    {
        return $this->timeIn;
    }

    /**
     * Retrieve the timeOut value
     *
     * @return \Carbon\Carbon
     */
    public function timeOut()
    {
        return $this->timeOut;
    }

    /**
     * Set the timein variable.
     *
     * @param string $timeIn
     */
    public function setTimeOut($timeOut)
    {
        $this->timeOut = $this->parse($timeOut);

        return $this;
    }

    /**
     * Calculate the total hours
     * in the morning since time in to lunch.
     *
     * @return self
     */
    public function totalAM()
    {
        $timeIn = $this->timeIn();
        $timeOut = $this->timeOut();
        $this->total = $timeIn->diff($timeIn); // 00:00:00

        if ($this->includeLuncheonHour()) {
            if ($this->isBeforeLunch($timeIn) && $this->isAfterLunch($timeOut)) {
                $this->total = $timeIn->diff($this->lunchStart());
            } elseif ($this->isBeforeLunch($timeIn) && $this->isBeforeLunch($timeOut)) {
                $this->total = $timeIn->diff($timeOut);
            }
        }

        return $this;
    }

    /**
     * Calculate the total hours
     * in the afternoon from lunch end to time out.
     *
     * @return self
     */
    public function totalPM()
    {
        $timeOut = $this->timeOut();
        $timeIn = $this->timeIn();
        $this->total = $timeIn->diff($timeOut);

        if ($this->includeLuncheonHour()) {
            if ($this->isBeforeLunch($timeIn) && $this->isAfterLunch($timeOut)) {
                $this->total = $timeOut->diff($this->lunchEnd());
            }

            if ($this->isBeforeLunch($timeIn) && $this->isBeforeLunch($timeOut)) {
                $this->total = $timeOut->diff($timeOut);
            }
        }

        return $this;
    }

    /**
     * Calculate the total hourse of given times.
     *
     * @param  string $timeIn
     * @param  string $timeOut
     * @param  string $lunchStart
     * @param  string $lunchEnd
     * @return string
     */
    public function totalDuration()
    {
        $timeIn = $this->timeIn();
        $timeOut = $this->timeOut();

        $this->total = $timeIn->diff($timeOut);

        if ($this->includeLuncheonHour() && $this->isBeforeLunch($timeIn) && $this->isAfterLunch($timeOut)) {
            $this->total = $this->totalDurationMinusLunchHours($this->total);
        }

        return $this;
    }

    /**
     * Calculate total subtracting the lunch hours.
     * @param \DateInterval $time
     * @return DateInterval
     */
    protected function totalDurationMinusLunchHours($time)
    {
        return $this->parse($time->format('%H:%I:%S'))->diff($this->getTotalLunchHours());
    }

    /**
     * Retrieve total value.
     *
     * @return mixed
     */
    protected function total()
    {
        return $this->total;
    }
}
