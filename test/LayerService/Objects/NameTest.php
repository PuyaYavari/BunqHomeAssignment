<?php declare(strict_types=1);

namespace test\LayerService\Objects;

use \PHPUnit\Framework\TestCase;
use \App\LayerService\Objects\Name;
use Faker;

/**
 * @author Pouya
 */
final class NameTest extends TestCase
{
    public function testGetNameStringType()
    {
        $faker = Faker\Factory::create();
        $name = $faker->firstName(null);
        $nameObject = new Name($name);
        $this->assertIsString($nameObject->getNameString());
    }

    /**
     * @depends testGetNameStringType
     */
    public function testGetNameStringValue()
    {
        $faker = Faker\Factory::create();
        $name = $faker->firstName(null);
        $nameObject = new Name($name);
        $this->assertEquals($name, $nameObject->getNameString());
    }
}

?>