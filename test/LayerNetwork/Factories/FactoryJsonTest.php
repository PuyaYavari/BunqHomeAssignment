<?php declare(strict_types=1);

namespace test\LayerNetwork\Factories;

use \PHPUnit\Framework\TestCase;
use \App\LayerService\Objects\Id;
use \App\LayerService\Objects\Name;
use \App\LayerService\Objects\Surname;
use \App\LayerService\Objects\Fullname;
use \App\LayerService\Objects\Username;
use \App\LayerService\Objects\PhavaText;
use \App\LayerService\Objects\PhavaDatetime;
use \App\LayerService\ServiceModels\User;
use \App\LayerService\ServiceModels\Message;
use \App\LayerNetwork\Factories\FactoryJson;
use Faker;

final class FactoryJsonTest extends TestCase
{
    public function testGenerateErrorJsonType()
    {
        $faker = Faker\Factory::create();
        $text = $faker->text(100);
        $jsonFactory = new FactoryJson();
        $this->assertIsString($jsonFactory->generateErrorJson($text));
    }
    
    /**
     * @depends testGenerateErrorJsonType
     */
    public function testGenerateErrorJsonValue()
    {
        $faker = Faker\Factory::create();
        $text = $faker->text(100);
        $jsonFactory = new FactoryJson();
        $this->assertEquals('{"Error":"' . $text . '"}', $jsonFactory->generateErrorJson($text));
    }

    /**
     * @dataProvider userProvider
     */
    public function testGenerateUserJsonType(string $userJson, User $userObject)
    {
        $jsonFactory = new FactoryJson();
        $this->assertIsString($jsonFactory->generateUserJson($userObject));
    }
    
    /**
     * @depends testGenerateUserJsonType
     * @dataProvider userProvider
     */
    public function testGenerateUserJsonValue(string $userJson, User $userObject)
    {
        $jsonFactory = new FactoryJson();
        $this->assertEquals($userJson, $jsonFactory->generateUserJson($userObject));
    }
    
    /**
     * @dataProvider messageProvider
     */
    public function testGenerateMessageJsonType(string $messageJson, Message $messageObject)
    {
        $jsonFactory = new FactoryJson();
        $this->assertIsString($jsonFactory->generateMessageJson($messageObject));
    }
    
    /**
     * @depends testGenerateMessageJsonType
     * @dataProvider messageProvider
     */
    public function testGenerateMessageJsonValue(string $messageJson, Message $messageObject)
    {
        $jsonFactory = new FactoryJson();
        $this->assertEquals($messageJson, $jsonFactory->generateMessageJson($messageObject));
    }

    /**
     * @dataProvider messagesProvider
     */
    public function testGenerateMessagesJsonType(string $messagesJson, Array $messagesArray)
    {
        $jsonFactory = new FactoryJson();
        $this->assertIsString($jsonFactory->generateMessagesJson($messagesArray));
    }
    
    /**
     * @depends testGenerateMessagesJsonType
     * @dataProvider messagesProvider
     */
    public function testGenerateMessagesJsonValue(string $messagesJson, Array $messagesArray)
    {
        $jsonFactory = new FactoryJson();
        $this->assertEquals($messagesJson, $jsonFactory->generateMessagesJson($messagesArray));
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
        $userJson = json_encode(array(
            "Id" => $id,
            "Name" => $name,
            "Surname" => $surname,
            "Username" => $username
        ));
        $userObject = new User($idObject, $fullnameObject, $usernameObject);

        return [[
            $userJson,
            $userObject
        ]];    
    }

    public function messageProvider(): array
    {
        $faker = Faker\Factory::create();

        $messageId = Rand()+1;
        $messageIdObject = new Id($messageId);

        $senderName = $faker->firstName(null);
        $senderNameObject = new Name($senderName);
        $senderSurname = $faker->lastname();
        $senderSurnameObject = new Surname($senderSurname);
        $senderFullnameObject = new Fullname($senderNameObject, $senderSurnameObject);
        $senderUsername = $faker->word();
        $senderUsernameObject = new Username($senderUsername);
        $senderIdObject = new Id(Rand()+1);
        $senderUserObject = new User($senderIdObject, $senderFullnameObject, $senderUsernameObject);

        $receiverName = $faker->firstName(null);
        $receiverNameObject = new Name($receiverName);
        $receiverSurname = $faker->lastname();
        $receiverSurnameObject = new Surname($receiverSurname);
        $receiverFullnameObject = new Fullname($receiverNameObject, $receiverSurnameObject);
        $receiverUsername = $faker->word();
        $receiverUsernameObject = new Username($receiverUsername);
        $receiverIdObject = new Id(Rand()+1);
        $receiverUserObject = new User($receiverIdObject, $receiverFullnameObject, $receiverUsernameObject);

        $bodyText = $faker->text(1000);
        $bodyPhavaTextObject = new PhavaText($bodyText);

        $datetime = $faker->dateTime($max = 'now', $timezone = null);
        $datetimeString = $datetime->format('Y-m-d H:i:s');
        $phavaDatetimeObject = new PhavaDatetime($datetimeString);

        $isReceived = Rand(0,1) < 1;

        $responseMessageId = Rand()+1;
        $responseMessageIdObject = new Id($responseMessageId);

        $responseBodyText = $faker->text(1000);
        $responseBodyPhavaTextObject = new PhavaText($responseBodyText);

        $responseDatetime = $faker->dateTime($max = 'now', $timezone = null);
        $responseDatetimeString = $responseDatetime->format('Y-m-d H:i:s');
        $responsePhavaDatetimeObject = new PhavaDatetime($responseDatetimeString);

        $responseIsReceived = Rand(0,1) < 1;

        $messageObject = new Message(
            $messageIdObject,
            $senderUserObject,
            $receiverUserObject,
            $bodyPhavaTextObject,
            $phavaDatetimeObject,
            null,
            $isReceived
        );

        $messageJson = json_encode(array(
            "Id" => $messageId,
            "Sender" => $senderUsername,
            "Receiver" => $receiverUsername,
            "Body" => $bodyText,
            "ResponseTo" => null,
            "Time" => $datetimeString
        ));

        $responseMessageObject = new Message(
            $responseMessageIdObject,
            $senderUserObject,
            $receiverUserObject,
            $responseBodyPhavaTextObject,
            $responsePhavaDatetimeObject,
            $messageObject,
            $responseIsReceived
        );

        $responseMessageJson = json_encode(array(
            "Id" => $responseMessageId,
            "Sender" => $senderUsername,
            "Receiver" => $receiverUsername,
            "Body" => $responseBodyText,
            "ResponseTo" => $bodyText,
            "Time" => $responseDatetimeString
        ));

        return [[
            $messageJson,
            $messageObject
        ],[
            $responseMessageJson,
            $responseMessageObject
        ]];
    }

    public function messagesProvider(): array
    {
        $faker = Faker\Factory::create();

        $messagesArray = [];
        $messagesArrayArray = [];

        $count = Rand(5,10);
        for($i = 0; $i <= $count; $i++)
        {
            $messageId = Rand()+1;
            $messageIdObject = new Id($messageId);

            $senderName = $faker->firstName(null);
            $senderNameObject = new Name($senderName);
            $senderSurname = $faker->lastname();
            $senderSurnameObject = new Surname($senderSurname);
            $senderFullnameObject = new Fullname($senderNameObject, $senderSurnameObject);
            $senderUsername = $faker->word();
            $senderUsernameObject = new Username($senderUsername);
            $senderIdObject = new Id(Rand()+1);
            $senderUserObject = new User($senderIdObject, $senderFullnameObject, $senderUsernameObject);

            $receiverName = $faker->firstName(null);
            $receiverNameObject = new Name($receiverName);
            $receiverSurname = $faker->lastname();
            $receiverSurnameObject = new Surname($receiverSurname);
            $receiverFullnameObject = new Fullname($receiverNameObject, $receiverSurnameObject);
            $receiverUsername = $faker->word();
            $receiverUsernameObject = new Username($receiverUsername);
            $receiverIdObject = new Id(Rand()+1);
            $receiverUserObject = new User($receiverIdObject, $receiverFullnameObject, $receiverUsernameObject);

            $bodyText = $faker->text(1000);
            $bodyPhavaTextObject = new PhavaText($bodyText);

            $datetime = $faker->dateTime($max = 'now', $timezone = null);
            $datetimeString = $datetime->format('Y-m-d H:i:s');
            $phavaDatetimeObject = new PhavaDatetime($datetimeString);

            $isReceived = Rand(0,1) < 1;

            $responseMessageId = Rand()+1;
            $responseMessageIdObject = new Id($responseMessageId);

            $responseBodyText = $faker->text(1000);
            $responseBodyPhavaTextObject = new PhavaText($responseBodyText);

            $responseDatetime = $faker->dateTime($max = 'now', $timezone = null);
            $responseDatetimeString = $responseDatetime->format('Y-m-d H:i:s');
            $responsePhavaDatetimeObject = new PhavaDatetime($responseDatetimeString);

            $responseIsReceived = Rand(0,1) < 1;

            $messageObject = new Message(
                $messageIdObject,
                $senderUserObject,
                $receiverUserObject,
                $bodyPhavaTextObject,
                $phavaDatetimeObject,
                null,
                $isReceived
            );

            $messageArray = array(
                "Id" => $messageId,
                "Sender" => $senderUsername,
                "Receiver" => $receiverUsername,
                "Body" => $bodyText,
                "ResponseTo" => null,
                "Time" => $datetimeString
            );

            $responseMessageObject = new Message(
                $responseMessageIdObject,
                $senderUserObject,
                $receiverUserObject,
                $responseBodyPhavaTextObject,
                $responsePhavaDatetimeObject,
                $messageObject,
                $responseIsReceived
            );

            $responseMessageArray = array(
                "Id" => $responseMessageId,
                "Sender" => $senderUsername,
                "Receiver" => $receiverUsername,
                "Body" => $responseBodyText,
                "ResponseTo" => $bodyText,
                "Time" => $responseDatetimeString
            );

            if(Rand(0,1) < 1)
            {
                array_push($messagesArray, $messageObject);
                array_push($messagesArrayArray, $messageArray);
            } else {
                array_push($messagesArray, $responseMessageObject);
                array_push($messagesArrayArray, $responseMessageArray);
            }
        }

        return [[
            json_encode($messagesArrayArray),
            $messagesArray
        ]];
    }
}
?>