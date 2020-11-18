<?php declare(strict_types=1);

namespace test\LayerService\Objects;

use \PHPUnit\Framework\TestCase;
use \App\LayerService\Objects\PhavaDatetime;
use Faker;

/**
 * @author Pouya
 */
final class PhavaDatetimeTest extends TestCase
{
    public function testGetDatetimeValue()
    {
        $faker = Faker\Factory::create();
        $datetime = $faker->dateTime($max = 'now', $timezone = null);
        $phavaDatetimeObject = new PhavaDatetime($datetime->format('Y-m-d H:i:s'));
        $this->assertEquals($datetime, $phavaDatetimeObject->getDatetime());
    }

    /**
     * @depends testGetDatetimeValue
     */
    public function testGetDatetimeStringType()
    {
        $faker = Faker\Factory::create();
        $datetime = $faker->dateTime($max = 'now', $timezone = null);
        $datetimeString = $datetime->format('Y-m-d H:i:s');
        $phavaDatetimeObject = new PhavaDatetime($datetimeString);
        $this->assertIsString($phavaDatetimeObject->getDatetimeString());
    }

    /**
     * @depends testGetDatetimeStringType
     */
    public function testGetDatetimeStringValue()
    {
        $faker = Faker\Factory::create();
        $datetime = $faker->dateTime($max = 'now', $timezone = null);
        $datetimeString = $datetime->format('Y-m-d H:i:s');
        $phavaDatetimeObject = new PhavaDatetime($datetimeString);
        $this->assertEquals($datetimeString, $phavaDatetimeObject->getDatetimeString());
    }
}

?>