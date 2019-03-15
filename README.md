# :card_index: Punchcard

A PHP Library for interacting with time records, time in, and time out.

<br>

#### Requirements
* **php**: `>=7.1`
* **nesbot/carbon**: `^2.16`

<br>

#### Installation

```bash
$ composer require codrasil/punchcard
```
```json
{
    "require": {
        "codrasil/punchcard": "^1.0.0"
    }
}
```

<br>

#### Usage

```php
use Codrasil\Punchcard\Punchcard;

$punchcard = new Punchcard;

$punchcard->setTimeIn('8:00 AM') // parses into 08:00:00 format
          ->setTimeOut('5 PM');  // uses Carbon\Carbon for parsing strings to \DateTime

$punchcard->lunch($deductLunchHours = true); // calculate with lunch hours substracted

echo $punchcard->totalDuration()->toString();
// performs: $timeOut - $timeIn = $duration in 00:00:00 format.
// ouputs: 08:00:00

echo $punchcard->totalAM();
// ouputs: 04:00:00

echo $punchcard->totalPM();
// ouputs: 04:00:00

$punchcard->lunch(false);
echo $punchcard->totalDuration()->toString();
// ouputs: 09:00:00

// Other methods:
$punchcard->totalTardy()->toString();
$punchcard->totalTardyAM()->toString(); // this is the same with totalTardy
$punchcard->totalTardyPM()->toString();
$punchcard->totalOvertime()->toString();
$punchcard->totalOvertimeAM()->toString();
$punchcard->totalOvertimePM()->toString(); // this is the same with totalOvertime
$punchcard->totalUndertime()->toString();
$punchcard->totalUndertimeAM()->toString(); // requires option `time_in_end`
$punchcard->totalUndertimePM()->toString(); // this is the same with totalUndertime
```

#### Options

You may pass options upon initialization:
```php
$options = [
    'default_time_in' => '09:00:00', // default is 08:00:00
    'default_time_out' => '18:00:00', // default is 17:00:00
    'default_lunch_start' => '12:00:00', // default 12:00:00
    'default_lunch_end' => '13:00:00', // default 13:00:00
];

$punchcard = new Punchcard($options);
```
Or via method `setParams`:
```php
$punchcard->setParams($options);
```



