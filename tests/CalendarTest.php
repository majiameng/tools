<?php

use PHPUnit\Framework\TestCase;
use tinymeng\tools\Calendar;

class CalendarTest extends TestCase
{
    protected $calendar;

    protected function setUp(): void
    {
        $this->calendar = new Calendar();
    }

    public function testSolarToLunar()
    {
        $result = $this->calendar->solar(2025, 1, 1);
        $this->assertEquals('2025', $result['gregorian_year']);
        $this->assertEquals('01', $result['gregorian_month']);
        $this->assertEquals('01', $result['gregorian_day']);
        $this->assertEquals('甲辰', $result['ganzhi_year']);
        $this->assertEquals('腊月', $result['lunar_month_chinese']);
        $this->assertEquals('初二', $result['lunar_day_chinese']);
    }

    public function testLunarToSolar()
    {
        $result = $this->calendar->lunar(2023, 9, 1);
        $this->assertEquals('2023', $result['lunar_year']);
        $this->assertEquals('09', $result['lunar_month']);
        $this->assertEquals('01', $result['lunar_day']);
    }

    public function testDaysOfYear()
    {
        $days = $this->calendar->daysOfYear(2023);
        $this->assertEquals(384, $days);
    }

    public function testMonthsOfYear()
    {
        $months = $this->calendar->monthsOfYear(2023);
        $this->assertEquals(13, $months);
    }

    public function testLeapMonth()
    {
        $leapMonth = $this->calendar->leapMonth(2023);
        $this->assertEquals(2, $leapMonth);
    }

    public function testLeapDays()
    {
        $leapDays = $this->calendar->leapDays(2023);
        $this->assertEquals(29, $leapDays);
    }

    public function testLunarDays()
    {
        $days = $this->calendar->lunarDays(2023, 9);
        $this->assertEquals(29, $days);
    }

    public function testSolarDays()
    {
        $days = $this->calendar->solarDays(2023, 10);
        $this->assertEquals(31, $days);
    }

    public function testGanZhiYear()
    {
        $ganZhiYear = $this->calendar->ganZhiYear(2023);
        $this->assertEquals('癸卯', $ganZhiYear);
    }

    public function testToConstellation()
    {
        $constellation = $this->calendar->toConstellation(10, 1);
        $this->assertEquals('天秤', $constellation);
    }

    public function testToGanZhi()
    {
        $ganZhi = $this->calendar->toGanZhi(0);
        $this->assertEquals('甲子', $ganZhi);
    }

    public function testGetTerm()
    {
        $term = $this->calendar->getTerm(2023, 1);
        $this->assertEquals('5', $term);
    }

    public function testToChinaYear()
    {
        $chineseYear = $this->calendar->toChinaYear(2023);
        $this->assertEquals('二零二三', $chineseYear);
    }

    public function testToChinaMonth()
    {
        $chineseMonth = $this->calendar->toChinaMonth(9);
        $this->assertEquals('九月', $chineseMonth);
    }

    public function testToChinaDay()
    {
        $chineseDay = $this->calendar->toChinaDay(1);
        $this->assertEquals('初一', $chineseDay);
    }

    public function testGetAnimal()
    {
        $animal = $this->calendar->getAnimal(2023);
        $this->assertEquals('兔', $animal);
    }

    public function testSolar2LunarWithHour()
    {
        $result = $this->calendar->solar2lunar(2023, 10, 1, 23);
        $this->assertEquals('2023', $result['lunar_year']);
        $this->assertEquals('08', $result['lunar_month']);
        $this->assertEquals('18', $result['lunar_day']);
    }

    public function testLunar2SolarWithLeapMonth()
    {
        $result = $this->calendar->lunar2solar(2023, 9, 1, true);
        $this->assertEquals('2023', $result['solar_year']);
        $this->assertEquals('10', $result['solar_month']);
        $this->assertEquals('15', $result['solar_day']);
    }

    public function testDateDiff()
    {
        $diff = $this->calendar->dateDiff('2023-10-01', '2023-10-02');
        $this->assertEquals(1, $diff->days);
    }

    public function testDiffInYears()
    {
        $lunar1 = $this->calendar->solar2lunar(2023, 10, 1);
        $lunar2 = $this->calendar->solar2lunar(2024, 10, 1);
        $diff = $this->calendar->diffInYears($lunar1, $lunar2);
        $this->assertEquals(1, $diff);
    }

    public function testDiffInMonths()
    {
        $lunar1 = $this->calendar->solar2lunar(2023, 10, 1);
        $lunar2 = $this->calendar->solar2lunar(2023, 11, 1);
        $diff = $this->calendar->diffInMonths($lunar1, $lunar2);
        $this->assertEquals(1, $diff);
    }

    public function testDiffInDays()
    {
        $lunar1 = $this->calendar->solar2lunar(2023, 10, 1);
        $lunar2 = $this->calendar->solar2lunar(2023, 10, 2);
        $diff = $this->calendar->diffInDays($lunar1, $lunar2);
        $this->assertEquals(1, $diff);
    }

    public function testAddYears()
    {
        $lunar = $this->calendar->solar2lunar(2023, 10, 1);
        $result = $this->calendar->addYears($lunar, 1);
        $this->assertEquals('2024', $result['lunar_year']);
    }

    public function testSubYears()
    {
        $lunar = $this->calendar->solar2lunar(2023, 10, 1);
        $result = $this->calendar->subYears($lunar, 1);
        $this->assertEquals('2022', $result['lunar_year']);
    }

    public function testAddMonths()
    {
        $lunar = $this->calendar->solar2lunar(2023, 10, 1);
        $result = $this->calendar->addMonths($lunar, 1);
        $this->assertEquals('09', $result['lunar_month']);
    }

    public function testSubMonths()
    {
        $lunar = $this->calendar->solar2lunar(2023, 10, 1);
        $result = $this->calendar->subMonths($lunar, 1);
        $this->assertEquals('07', $result['lunar_month']);
    }

    public function testAddDays()
    {
        $lunar = $this->calendar->solar2lunar(2023, 10, 1);
        $result = $this->calendar->addDays($lunar, 1);
        $this->assertEquals('18', $result['lunar_day']);
    }

    public function testSubDays()
    {
        $lunar = $this->calendar->solar2lunar(2023, 10, 1);
        $result = $this->calendar->subDays($lunar, 1);
        $this->assertEquals('16', $result['lunar_day']);
    }
}