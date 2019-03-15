<?php

namespace Codrasil\Punchcard\Test\Unit;

use Codrasil\Punchcard\Punchcard;
use Codrasil\Punchcard\Test\TestCase;

/**
 * @package Tests\Unit
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class PunchcardTest extends TestCase
{
    /**
     * @test
     * @group  punchcard
     * @group  punchcard:helper
     */
    public function testHelperFunctionExists()
    {
        $punchcard = new Punchcard;
        $classTotalDuration = $punchcard->setTimeIn('8:00 AM')
                                        ->setTimeOut('5 PM')
                                        ->totalDuration()
                                        ->toString();

        $functionTotalDuration = punchcard()->setTimeIn('8:00 AM')
                                            ->setTimeOut('5 PM')
                                            ->totalDuration()
                                            ->toString();

        $this->assertInstanceOf(Punchcard::class, punchcard());
        $this->assertSame($classTotalDuration, $functionTotalDuration);
    }

    /**
     * @test
     * @group punchcard
     * @group unit:punchcard
     * @group punchcard:init
     */
    public function testItCanInitializeWithParams()
    {
        $params = [
            'default_time_in' => '08:00:00',
            'default_time_out' => '17:00:00',
            'default_lunch_start' => '12:00:00',
            'default_lunch_end' => '13:00:00',
        ];
        $punchcard = new Punchcard($params);

        $this->assertStringContainsString($params['default_time_in'], $punchcard->getParam('default_time_in')->format('H:i:s'));
        $this->assertStringContainsString($params['default_time_out'], $punchcard->getParam('default_time_out')->format('H:i:s'));
        $this->assertStringContainsString($params['default_lunch_start'], $punchcard->getParam('default_lunch_start')->format('H:i:s'));
        $this->assertStringContainsString($params['default_lunch_end'], $punchcard->getParam('default_lunch_end')->format('H:i:s'));
        $this->assertIsArray($punchcard->getParams());
    }

    /**
     * @test
     * @group punchcard
     * @group unit:punchcard
     * @group punchcard@setParam
     */
    public function testItCanSetParamsAfterInitialization()
    {
        $params = [
            'default_time_in' => '08:00:00',
            'default_time_out' => '17:00:00',
            'default_lunch_start' => '12:00:00',
            'default_lunch_end' => '13:00:00',
        ];

        $punchcard = new Punchcard();
        $punchcard->setParams($params);

        $this->assertIsArray($punchcard->getParams());
        $this->assertStringContainsString($params['default_time_in'], $punchcard->getParam('default_time_in'));
    }

    /**
     * @test
     * @group punchcard
     * @group unit:punchcard
     * @group punchcard@getParam
     */
    public function testItCanRetrieveTheValueOfAGivenParameter()
    {
        $params = [
            'default_time_in' => '08:00:00',
            'default_time_out' => '17:00',
            'default_lunch_start' => '12:00:00',
            'default_lunch_end' => '13:00:00',
        ];

        $punchcard = new Punchcard($params);

        $this->assertSame($params['default_time_in'], $punchcard->getParam('default_time_in')->format('H:i:s'));
        $this->assertNotSame('17:00', $punchcard->getParam('default_time_out')->format('H:i:s'));
        $this->assertSame('17:00:00', $punchcard->getParam('default_time_out')->format('H:i:s'));
    }

    /**
     * @test
     * @group punchcard
     * @group unit:punchcard
     * @group punchcard@totalAM
     * @dataProvider \Codrasil\Punchcard\Test\DataProvider\PunchcardDataProvider::providerTimeData
     */
    public function testItCanCalculateTotalTimePassedInMorning($data, $params, $expected)
    {
        $punchcard = new Punchcard($params);
        $punchcard->setTimeIn($data['time_in'])->setTimeOut($data['time_out']);

        /**
         * Assert it can calculate total AM duration from:
         * given time, $data['time_in']
         * against $params['default_lunch_start']
         * $lunchStart - $timeIn
         *
         */
        $totalAM = $punchcard->totalAM();
        $this->assertSame($expected['total_AM'], $totalAM->toString());
        $this->assertSame($expected['total_AM'], $totalAM->toDuration());
    }

    /**
     * @test
     * @group punchcard
     * @group unit:punchcard
     * @group punchcard@totalPM
     * @dataProvider \Codrasil\Punchcard\Test\DataProvider\PunchcardDataProvider::providerTimeData
     */
    public function testItCanCalculateTotalTimePassedInAfternoon($data, $params, $expected)
    {
        $punchcard = new Punchcard($params);

        $punchcard->setTimeIn($data['time_in'])
                  ->setTimeOut($data['time_out']);

        /**
         * PM calculations
         * $lunchEnd - $timeOut
         *
         */
        $totalPM = $punchcard->totalPM();
        $this->assertSame($expected['total_PM'], $totalPM->toString());
        $this->assertSame($expected['total_PM'], $totalPM->toDuration());
    }

    /**
     * @test
     * @group punchcard
     * @group unit:punchcard
     * @group punchcard@totalDuration
     * @dataProvider \Codrasil\Punchcard\Test\DataProvider\PunchcardDataProvider::providerTimeData
     */
    public function testItCanCalculateTotalTimePassed($data, $params, $expected)
    {
        $punchcard = new Punchcard($params);
        $punchcard->setTimeIn($data['time_in'])->setTimeOut($data['time_out']);

        /**
         * Total Duration calculation
         * ($timeOut - $timeIn) - ($lunchOut - $lunchIn)
         *
         */
        $totalDuration = $punchcard->totalDuration();
        $this->assertSame($expected['total_duration'], $totalDuration->toString());
        $this->assertSame($expected['total_duration'], $totalDuration->toDuration());
    }

    /**
     * @test
     * @group punchcard
     * @group unit:punchcard
     * @group punchcard@totalDurationWithoutLunch
     * @dataProvider \Codrasil\Punchcard\Test\DataProvider\PunchcardDataProvider::providerTimeData
     */
    public function testItCanCalculateTotalTimePassedWithoutSubtractingLunchHours($data, $params, $expected)
    {
        $punchcard = new Punchcard($params);
        $punchcard->setTimeIn($data['time_in'])
                  ->setTimeOut($data['time_out'])
                  ->lunch(false);

        /**
         * Total Duration calculation
         * ($timeOut - $timeIn)
         *
         */
        $totalDuration = $punchcard->totalDuration();
        $this->assertSame($expected['total_duration_without_lunch'], $totalDuration->toString());
    }

    /**
     * @test
     * @group punchcard
     * @group unit:punchcard
     * @group punchcard:traits
     * @group punchcard@lunch
     */
    public function testItSetTheLunchInclusion()
    {
        $punchcard = new Punchcard();
        $this->assertTrue($punchcard->includeLuncheonHour());

        $punchcard->lunch(false);
        $this->assertFalse($punchcard->includeLuncheonHour());
    }

    /**
     * @test
     * @group punchcard
     * @group unit:punchcard
     * @group punchcard:traits
     * @group punchcard@toSeconds
     * @dataProvider \Codrasil\Punchcard\Test\DataProvider\PunchcardDataProvider::providerTimeData
     */
    public function testItCanParseStringsToSecondsAndReturnInteger($data, $params, $expected)
    {
        $punchcard = new Punchcard;

        $punchcard->setTimeIn($data['time_in'])
                  ->setTimeOut($data['time_out']);

        $totalDurationInSeconds = $punchcard->totalDuration()->toSeconds();
        $this->assertSame($expected['total_duration_in_seconds'], $totalDurationInSeconds);
    }

    /**
     * @test
     * @group punchcard
     * @group unit:punchcard
     * @group punchcard:traits
     * @group punchcard@toString
     * @dataProvider \Codrasil\Punchcard\Test\DataProvider\PunchcardDataProvider::providerTimeData
     */
    public function testItCanParseStringsToStringTime($data, $params, $expected)
    {
        $punchcard = new Punchcard;

        $punchcard->setTimeIn($data['time_in'])
                  ->setTimeOut($data['time_out']);

        $totalDuration = $punchcard->totalDuration()->toString();
        $this->assertSame($expected['total_duration'], $totalDuration);
    }

    /**
     * @test
     * @group punchcard
     * @group unit:punchcard
     * @group punchcard@carbon
     */
    public function testItReturnsTheCarbonInstanceViaCarbonMethod()
    {
        $punchcard = new Punchcard;

        $this->assertInstanceOf('\Carbon\Carbon', $punchcard->carbon());
    }

    /**
     * @test
     * @group punchcard
     * @group unit:punchcard
     * @group punchcard@carbon
     */
    public function testItCanParseAStringIntoDateTimeObject()
    {
        $punchcard = new Punchcard;

        $this->assertInstanceOf('\Carbon\Carbon', $punchcard->parse('08:00 AM'));
    }

    /**
     * @test
     * @group punchcard
     * @group unit:punchcard
     * @group punchcard@tardy
     * @group punchcard@tardyAM
     * @dataProvider \Codrasil\Punchcard\Test\DataProvider\PunchcardDataProvider::providerTardyTimeData
     */
    public function testItCanCalculateTotalTardyTime($data, $options, $expected)
    {
        $punchcard = new Punchcard($options);
        $punchcard->setTimeIn($data['time_in']);

        $this->assertSame($expected['total_tardy'], $punchcard->totalTardy()->toString());
        $this->assertSame($expected['total_tardy'], $punchcard->totalTardyAM()->toString());
    }

    /**
     * @test
     * @group punchcard
     * @group unit:punchcard
     * @group punchcard@tardy
     * @group punchcard@tardyPM
     * @dataProvider \Codrasil\Punchcard\Test\DataProvider\PunchcardDataProvider::providerTardyTimeData
     */
    public function testItCanCalculateTotalTardyTimeInAfternoon($data, $options, $expected)
    {
        $punchcard = new Punchcard($options);
        $punchcard->setTimeIn($data['pm_time_in']);

        $this->assertSame($expected['total_tardy_PM'], $punchcard->totalTardyPM()->toString());
    }

    /**
     * @test
     * @group punchcard
     * @group unit:punchcard
     * @group punchcard@overtime
     * @dataProvider \Codrasil\Punchcard\Test\DataProvider\PunchcardDataProvider::providerOvertimeData
     */
    public function testItCanCalculateTotalOvertime($data, $options, $expected)
    {
        $punchcard = new Punchcard($options);
        $punchcard->setTimeOut($data['time_out']);

        $this->assertSame($expected['total_overtime'], $punchcard->totalOvertime()->toString());
    }

    /**
     * @test
     * @group punchcard
     * @group unit:punchcard
     * @group punchcard@undertime
     * @dataProvider \Codrasil\Punchcard\Test\DataProvider\PunchcardDataProvider::providerUndertimeData
     */
    public function testItCanCalculateTotalUndertime($data, $options, $expected)
    {
        $punchcard = new Punchcard($options);
        $punchcard->setTimeOut($data['time_out']);

        $this->assertSame($expected['total_undertime'], $punchcard->totalUndertime()->toString());
    }
}
