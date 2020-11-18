<?php declare(strict_types=1);

namespace test\LayerService\ServiceModels;

use \PHPUnit\Framework\TestCase;
use \App\LayerService\Objects\Id;
use \App\LayerService\Objects\Name;
use \App\LayerService\Objects\Surname;
use \App\LayerService\Objects\Fullname;
use \App\LayerService\Objects\Username;
use \App\LayerService\ServiceModels\User;
use Faker;

/**
 * @author Pouya
 */
final class UserTest extends TestCase
{
    /**
     * @depends test\LayerService\Objects\IdTest::testGetIdIntValue
     * @depends test\LayerService\Objects\UsernameTest::testGetUsernameStringValue
     * @depends test\LayerService\Objects\FullnameTest::testGetNameValue
     * @depends test\LayerService\Objects\FullnameTest::testGetSurnameValue
     * @dataProvider userProvider
     */
    public function testGetAsArrayIsArray(
        Id $idObject,
        Name $nameObject,
        Surname $surnameObject, 
        Fullname $fullnameObject,
        Username $usernameObject,
        User $userObject,
        Array $userArray
    )
    {
        $this->assertIsArray($userObject->getAsArray());
    }

    /**
     * @depends testGetAsArrayIsArray
     * @dataProvider userProvider
     */
    public function testGetAsArrayValue(
        Id $idObject,
        Name $nameObject,
        Surname $surnameObject, 
        Fullname $fullnameObject,
        Username $usernameObject,
        User $userObject,
        Array $userArray
    )
    {
        $this->assertEquals($userArray, $userObject->getAsArray());
    }

    /**
     * @dataProvider userProvider
     */
    public function testGetIdType(
        Id $idObject,
        Name $nameObject,
        Surname $surnameObject, 
        Fullname $fullnameObject,
        Username $usernameObject,
        User $userObject,
        Array $userArray
    )
    {
        $this->assertIsObject($userObject->getId());
    }

    /**
     * @depends testGetIdType
     * @dataProvider userProvider
     */
    public function testGetIdValue(
        Id $idObject,
        Name $nameObject,
        Surname $surnameObject, 
        Fullname $fullnameObject,
        Username $usernameObject,
        User $userObject,
        Array $userArray
    )
    {
        $this->assertEquals($idObject, $userObject->getId());
    }

    /**
     * @dataProvider userProvider
     */
    public function testGetNameType(
        Id $idObject,
        Name $nameObject,
        Surname $surnameObject, 
        Fullname $fullnameObject,
        Username $usernameObject,
        User $userObject,
        Array $userArray
    )
    {
        $this->assertIsObject($userObject->getName());
    }

    /**
     * @depends testGetNameType
     * @dataProvider userProvider
     */
    public function testGetNameValue(
        Id $idObject,
        Name $nameObject,
        Surname $surnameObject, 
        Fullname $fullnameObject,
        Username $usernameObject,
        User $userObject,
        Array $userArray
    )
    {
        $this->assertEquals($nameObject, $userObject->getName());
    }

    /**
     * @dataProvider userProvider
     */
    public function testGetSurnameType(
        Id $idObject,
        Name $nameObject,
        Surname $surnameObject, 
        Fullname $fullnameObject,
        Username $usernameObject,
        User $userObject,
        Array $userArray
    )
    {
        $this->assertIsObject($userObject->getSurname());
    }

    /**
     * @depends testGetSurnameType
     * @dataProvider userProvider
     */
    public function testGetSurnameValue(
        Id $idObject,
        Name $nameObject,
        Surname $surnameObject, 
        Fullname $fullnameObject,
        Username $usernameObject,
        User $userObject,
        Array $userArray
    )
    {
        $this->assertEquals($surnameObject, $userObject->getSurname());
    }

    /**
     * @dataProvider userProvider
     */
    public function testGetUsernameType(
        Id $idObject,
        Name $nameObject, 
        Surname $surnameObject, 
        Fullname $fullnameObject,
        Username $usernameObject,
        User $userObject,
        Array $userArray
    )
    {
        $this->assertIsObject($userObject->getUsername());
    }

    /**
     * @depends testGetUsernameType
     * @dataProvider userProvider
     */
    public function testGetUsernameValue(
        Id $idObject,
        Name $nameObject, 
        Surname $surnameObject, 
        Fullname $fullnameObject,
        Username $usernameObject,
        User $userObject,
        Array $userArray
    )
    {
        $this->assertEquals($usernameObject, $userObject->getUsername());
    }

    /**
     * @dataProvider userProvider
     */
    public function testCanSendMessageTo_Failure(
        Id $idObject,
        Name $nameObject, 
        Surname $surnameObject, 
        Fullname $fullnameObject,
        Username $usernameObject,
        User $userObject,
        Array $userArray
    )
    {
        $this->assertEquals(false, $userObject->canSendMessageTo($userObject));
    }

    /**
     * @dataProvider userProvider
     */
    public function testCanSendMessageTo_Success(
        Id $idObject,
        Name $nameObject, 
        Surname $surnameObject, 
        Fullname $fullnameObject,
        Username $usernameObject,
        User $userObject,
        Array $userArray
    )
    {
        $faker = Faker\Factory::create();
        $sencondUserName = $faker->firstName(null);
        $sencondUserNameObject = new Name($sencondUserName);
        $sencondUserSurname = $faker->lastname();
        $sencondUserSurnameObject = new Surname($sencondUserSurname);
        $sencondUserFullnameObject = new Fullname($sencondUserNameObject, $sencondUserSurnameObject);
        $sencondUserUsername = $faker->word();
        $sencondUserUsernameObject = new Username($sencondUserUsername);
        $sencondUserId = $idObject->getIdInt()+1;
        $sencondUserIdObject = new Id($sencondUserId);
        $sencondUserObject = new User($sencondUserIdObject, $sencondUserFullnameObject, $sencondUserUsernameObject);

        $this->assertEquals(true, $userObject->canSendMessageTo($sencondUserObject));
    }

    public function userProvider(): array
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
        $userArray = array(
            "Id" => $id,
            "Name" => $name,
            "Surname" => $surname,
            "Username" => $username
        );
        $userObject = new User($idObject, $fullnameObject, $usernameObject);

        return [[
            $idObject,
            $nameObject, 
            $surnameObject, 
            $fullnameObject,
            $usernameObject,
            $userObject,
            $userArray
        ]];    
    }
}

?>