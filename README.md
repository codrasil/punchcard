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
        "codrasil/punchcard": "^1.*"
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

$punchcard->lunch($deductLunchHours = true); // calculate with lunch hours subtracted

echo $punchcard->totalDuration()->toString();
// performs: $timeOut - $timeIn = $duration in 00:00:00 format.
// outputs: 08:00:00

echo $punchcard->totalAM();
// outputs: 04:00:00

echo $punchcard->totalPM();
// outputs: 04:00:00

$punchcard->lunch(false);
echo $punchcard->totalDuration()->toString();
// outputs: 09:00:00

// Other methods:
$punchcard->setTimeIn('8:15 AM');
$punchcard->totalTardy()->toString();
$punchcard->totalTardyAM()->toString(); // this is the same with totalTardy
// outputs: 00:15:00

// Assuming afternoon work resumes at 1PM:
$punchcard->setTimeIn('1:15 PM');
$punchcard->totalTardyPM()->toString();
// outputs: 00:15:00

// Assuming work ends at 5PM
$punchcard->setTimeOut('6:20 PM');
$punchcard->totalOvertime()->toString();
// outputs: 01:20:00

// Assuming work ends at 5PM
$punchcard->setTimeOut('4:20 PM');
$punchcard->totalUndertime()->toString();
// outputs: 5:00PM - 4:20PM = 00:40:00

// AM undertime calculate against default_lunch_start
$punchcard->totalUndertimeAM()->toString();
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

<br>

#### Documentation
coming soon

<br>

#### License

The Codrasil/Punchcard PHP library is open-source software licensed under the [MIT license](./LICENSE).
