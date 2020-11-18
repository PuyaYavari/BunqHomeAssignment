<?php declare(strict_types=1);

namespace test\LayerService\Factories\ServiceModelFactories;

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
use \App\LayerService\Factories\ServiceModelFactories\ServiceModelFactoryMessage;
use Faker;

/**
 * @author Pouya
 */
final class ServiceModelFactoryMessageTest extends TestCase
{
    /**
     * @depends test\LayerService\Objects\IdTest::testGetIdIntValue
     * @depends test\LayerService\ServiceModels\UserTest::testGetUsernameValue
     * @depends test\LayerService\Objects\UsernameTest::testGetUsernameStringValue
     * @depends test\LayerService\Objects\PhavaTextTest::testGetTextStringValue
     * @depends test\LayerService\Objects\PhavaDatetimeTest::testGetDatetimeStringValue
     * @dataProvider messageProvider
     */
    public function testGenerateMessageType(
        int $messageId, 
        User $senderUserObject, 
        User $receiverUserObject, 
        string $bodyText,
        string $datetimeString,
        Message $messageObject,
        bool $isReceived,
        ?Message $respondedToMessage
    )
    {
        $messageFactory = new ServiceModelFactoryMessage();
        $this->assertIsObject(
            $messageFactory->generateMessage(
                $messageId, 
                $senderUserObject, 
                $receiverUserObject, 
                $bodyText,
                $datetimeString,
                $respondedToMessage,
                $isReceived
            )
        );
    }

    /**
     * @depends test\LayerService\Objects\IdTest::testGetIdIntValue
     * @depends test\LayerService\ServiceModels\UserTest::testGetUsernameValue
     * @depends test\LayerService\Objects\UsernameTest::testGetUsernameStringValue
     * @depends test\LayerService\Objects\PhavaTextTest::testGetTextStringValue
     * @depends test\LayerService\Objects\PhavaDatetimeTest::testGetDatetimeStringValue
     * @dataProvider messageProvider
     */
    public function testGenerateMessageValue(
        int $messageId, 
        User $senderUserObject, 
        User $receiverUserObject, 
        string $bodyText,
        string $datetimeString,
        Message $messageObject,
        bool $isReceived,
        ?Message $respondedToMessage
    )
    {
        $messageFactory = new ServiceModelFactoryMessage();
        $this->assertEquals(
            $messageObject,
            $messageFactory->generateMessage(
                $messageId, 
                $senderUserObject, 
                $receiverUserObject, 
                $bodyText,
                $datetimeString,
                $respondedToMessage,
                $isReceived
            )
        );
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

        $responseMessageObject = new Message(
            $responseMessageIdObject,
            $senderUserObject,
            $receiverUserObject,
            $responseBodyPhavaTextObject,
            $responsePhavaDatetimeObject,
            $messageObject,
            $responseIsReceived
        );

        return [[
            $messageId, 
            $senderUserObject, 
            $receiverUserObject, 
            $bodyText,
            $datetimeString,
            $messageObject,
            $isReceived,
            null
        ],[
            $responseMessageId,
            $senderUserObject,
            $receiverUserObject,
            $responseBodyText,
            $responseDatetimeString,
            $responseMessageObject,
            $responseIsReceived,
            $messageObject
        ]];
    }
}
?>