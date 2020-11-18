<?php declare(strict_types=1);

namespace test\LayerService\Factories\ServiceModelFactories;

use \PHPUnit\Framework\TestCase;
use \App\LayerService\Objects\Id;
use \App\LayerService\Objects\Name;
use \App\LayerService\Objects\Surname;
use \App\LayerService\Objects\Fullname;
use \App\LayerService\Objects\Username;
use \App\LayerService\ServiceModels\User;
use \App\LayerService\Factories\ServiceModelFactories\ServiceModelFactoryUser;
use Faker;

/**
 * @author Pouya
 */
final class ServiceModelFactoryUserTest extends TestCase
{
    /**
     * @depends test\LayerService\Objects\IdTest::testGetIdIntValue
     * @depends test\LayerService\Objects\UsernameTest::testGetUsernameStringValue
     * @depends test\LayerService\Objects\FullnameTest::testGetNameValue
     * @depends test\LayerService\Objects\FullnameTest::testGetSurnameValue
     */
    public function testGenerateUserType()
    {
        $faker = Faker\Factory::create();
        $name = $faker->firstName(null);
        $surname = $faker->lastname();
        $username = $faker->word();
        $id = Rand()+1;
        $userFactory = new ServiceModelFactoryUser();
        $this->assertIsObject($userFactory->generateUser($id, $name, $surname, $username));
    }

    /**
     * @depends testGenerateUserType
     */
    public function testGenerateUserValue()
    {
        $faker = Faker\Factory::create();
        $name = $faker->firstName(null);
        $nameObject = new Name($name);
        $surname = $faker->lastname();
        $surnameObject = new Surname($surname);
        $fullnameObject = new Fullname($nameObject, $surnameObject);
        $username = $faker->word();
        $usernameObject = new Username($username);
        $id = Rand()+1;
        $idObject = new Id($id);
        $expectedUserObject = new User($idObject, $fullnameObject, $usernameObject);
        $userFactory = new ServiceModelFactoryUser();
        $this->assertEquals($expectedUserObject, $userFactory->generateUser($id, $name, $surname, $username));
    }
}
?>