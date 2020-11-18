<?php declare(strict_types=1);

namespace test\LayerService\Objects;

use \PHPUnit\Framework\TestCase;
use \App\LayerService\Objects\Fullname;
use \App\LayerService\Objects\Name;
use \App\LayerService\Objects\Surname;
use Faker;

/**
 * @author Pouya
 */
final class FullnameTest extends TestCase
{
    /**
     * @depends test\LayerService\Objects\NameTest::testGetNameStringValue
     * @dataProvider fullnameProvider
     */
    public function testGetNameType(
        Name $nameObject,
        Surname $surnameObject,
        Fullname $fullnameObject
    )
    {
        $this->assertIsObject($fullnameObject->getName());
    }

    /**
     * @depends test\LayerService\Objects\NameTest::testGetNameStringValue
     * @depends testGetNameType
     * @dataProvider fullnameProvider
     */
    public function testGetNameValue(
        Name $nameObject,
        Surname $surnameObject,
        Fullname $fullnameObject
    )
    {
        $this->assertEquals($nameObject, $fullnameObject->getName());
    }

    /**
     * @depends test\LayerService\Objects\SurnameTest::testGetSurnameStringValue
     * @dataProvider fullnameProvider
     */
    public function testGetSurnameType(
        Name $nameObject,
        Surname $surnameObject,
        Fullname $fullnameObject
    )
    {
        $this->assertIsObject($fullnameObject->getSurname());
    }

    /**
     * @depends test\LayerService\Objects\SurnameTest::testGetSurnameStringValue
     * @depends testGetSurnameType
     * @dataProvider fullnameProvider
     */
    public function testGetSurnameValue(
        Name $nameObject,
        Surname $surnameObject,
        Fullname $fullnameObject
    )
    {
        $this->assertEquals($surnameObject, $fullnameObject->getSurname());
    }


    public function fullnameProvider(): array
    {
        $faker = Faker\Factory::create();
        $name = $faker->firstName(null);
        $nameObject = new Name($name);
        $surname = $faker->lastname();
        $surnameObject = new Surname($surname);
        $fullnameObject = new Fullname($nameObject, $surnameObject);

        return[[
            $nameObject,
            $surnameObject,
            $fullnameObject
        ]];
    }
}

?>