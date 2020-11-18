<?php declare(strict_types=1);

namespace test\LayerService\Objects;

use \PHPUnit\Framework\TestCase;
use \App\LayerService\Objects\Surname;
use Faker;

/**
 * @author Pouya
 */
final class SurnameTest extends TestCase
{
    public function testGetSurnameStringType()
    {
        $faker = Faker\Factory::create();
        $surname = $faker->lastname();
        $surnameObject = new Surname($surname);
        $this->assertIsString($surnameObject->getSurnameString());
    }

    /**
     * @depends testGetSurnameStringType
     */
    public function testGetSurnameStringValue()
    {
        $faker = Faker\Factory::create();
        $surname = $faker->lastname();
        $surnameObject = new Surname($surname);
        $this->assertEquals($surname, $surnameObject->getSurnameString());
    }
}

?>