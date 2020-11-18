<?php declare(strict_types=1);

namespace test\LayerService\Objects;

use \PHPUnit\Framework\TestCase;
use \App\LayerService\Objects\Username;
use Faker;

/**
 * @author Pouya
 */
final class UsernameTest extends TestCase
{
    public function testGetUsernameStringType()
    {
        $faker = Faker\Factory::create();
        $username = $faker->word();
        $usernameObject = new Username($username);
        $this->assertIsString($usernameObject->getUsernameString());
    }

    /**
     * @depends testGetUsernameStringType
     */
    public function testGetUsernameStringValue()
    {
        $faker = Faker\Factory::create();
        $username = $faker->word();
        $usernameObject = new Username($username);
        $this->assertEquals($username, $usernameObject->getUsernameString());
    }
}

?>