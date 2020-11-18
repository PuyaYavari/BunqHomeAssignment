<?php declare(strict_types=1);

namespace test\LayerService\ServiceModels;

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
use Faker;

/**
 * @author Pouya
 */
final class MessageTest extends TestCase
{
    /**
     * @depends test\LayerService\Objects\IdTest::testGetIdIntValue
     * @depends test\LayerService\ServiceModels\UserTest::testGetUsernameValue
     * @depends test\LayerService\Objects\UsernameTest::testGetUsernameStringValue
     * @depends test\LayerService\Objects\PhavaTextTest::testGetTextStringValue
     * @depends test\LayerService\Objects\PhavaDatetimeTest::testGetDatetimeStringValue
     * @dataProvider messageProvider
     */
    public function testGetAsArrayType(
        Id $messageIdObject,
        User $senderUserObject,
        User $receiverUserObject,
        PhavaText $bodyPhavaTextObject,
        PhavaDatetime $phavaDatetimeObject,
        bool $isReceived,
        Message $messageObject,
        Array $messageArray,
        bool $isResponse,
        ?Message $respondedToMessage
    )
    {
        $this->assertIsArray($messageObject->getAsArray());
    }

    /**
     * @depends test\LayerService\Objects\IdTest::testGetIdIntValue
     * @depends test\LayerService\ServiceModels\UserTest::testGetUsernameValue
     * @depends test\LayerService\Objects\UsernameTest::testGetUsernameStringValue
     * @depends test\LayerService\Objects\PhavaTextTest::testGetTextStringValue
     * @depends test\LayerService\Objects\PhavaDatetimeTest::testGetDatetimeStringValue
     * @dataProvider messageProvider
     */
    public function testGetAsArrayValue_NotResponse(
        Id $messageIdObject,
        User $senderUserObject,
        User $receiverUserObject,
        PhavaText $bodyPhavaTextObject,
        PhavaDatetime $phavaDatetimeObject,
        bool $isReceived,
        Message $messageObject,
        Array $messageArray,
        bool $isResponse,
        ?Message $respondedToMessage
    )
    {
        $this->assertEquals($messageArray, $messageObject->getAsArray());
    }

    /**
     * @depends test\LayerService\Objects\IdTest::testGetIdIntValue
     * @depends test\LayerService\ServiceModels\UserTest::testGetUsernameValue
     * @depends test\LayerService\Objects\UsernameTest::testGetUsernameStringValue
     * @depends test\LayerService\Objects\PhavaTextTest::testGetTextStringValue
     * @depends test\LayerService\Objects\PhavaDatetimeTest::testGetDatetimeStringValue
     * @dataProvider messageProvider
     */
    public function testGetIdType(
        Id $messageIdObject,
        User $senderUserObject,
        User $receiverUserObject,
        PhavaText $bodyPhavaTextObject,
        PhavaDatetime $phavaDatetimeObject,
        bool $isReceived,
        Message $messageObject,
        Array $messageArray,
        bool $isResponse,
        ?Message $respondedToMessage
    )
    {
        $this->assertIsObject($messageObject->getId());
    }

    /**
     * @depends test\LayerService\Objects\IdTest::testGetIdIntValue
     * @depends test\LayerService\ServiceModels\UserTest::testGetUsernameValue
     * @depends test\LayerService\Objects\UsernameTest::testGetUsernameStringValue
     * @depends test\LayerService\Objects\PhavaTextTest::testGetTextStringValue
     * @depends test\LayerService\Objects\PhavaDatetimeTest::testGetDatetimeStringValue
     * @dataProvider messageProvider
     */
    public function testGetIdValue(
        Id $messageIdObject,
        User $senderUserObject,
        User $receiverUserObject,
        PhavaText $bodyPhavaTextObject,
        PhavaDatetime $phavaDatetimeObject,
        bool $isReceived,
        Message $messageObject,
        Array $messageArray,
        bool $isResponse,
        ?Message $respondedToMessage
    )
    {
        $this->assertEquals($messageIdObject, $messageObject->getId());
    }

    /**
     * @depends test\LayerService\Objects\IdTest::testGetIdIntValue
     * @depends test\LayerService\ServiceModels\UserTest::testGetUsernameValue
     * @depends test\LayerService\Objects\UsernameTest::testGetUsernameStringValue
     * @depends test\LayerService\Objects\PhavaTextTest::testGetTextStringValue
     * @depends test\LayerService\Objects\PhavaDatetimeTest::testGetDatetimeStringValue
     * @dataProvider messageProvider
     */
    public function testGetSenderUserType(
        Id $messageIdObject,
        User $senderUserObject,
        User $receiverUserObject,
        PhavaText $bodyPhavaTextObject,
        PhavaDatetime $phavaDatetimeObject,
        bool $isReceived,
        Message $messageObject,
        Array $messageArray,
        bool $isResponse,
        ?Message $respondedToMessage
    )
    {
        $this->assertIsObject($messageObject->getSenderUser());
    }

    /**
     * @depends test\LayerService\Objects\IdTest::testGetIdIntValue
     * @depends test\LayerService\ServiceModels\UserTest::testGetUsernameValue
     * @depends test\LayerService\Objects\UsernameTest::testGetUsernameStringValue
     * @depends test\LayerService\Objects\PhavaTextTest::testGetTextStringValue
     * @depends test\LayerService\Objects\PhavaDatetimeTest::testGetDatetimeStringValue
     * @dataProvider messageProvider
     */
    public function testGetSenderUserValue(
        Id $messageIdObject,
        User $senderUserObject,
        User $receiverUserObject,
        PhavaText $bodyPhavaTextObject,
        PhavaDatetime $phavaDatetimeObject,
        bool $isReceived,
        Message $messageObject,
        Array $messageArray,
        bool $isResponse,
        ?Message $respondedToMessage
    )
    {
        $this->assertEquals($senderUserObject, $messageObject->getSenderUser());
    }

    /**
     * @depends test\LayerService\Objects\IdTest::testGetIdIntValue
     * @depends test\LayerService\ServiceModels\UserTest::testGetUsernameValue
     * @depends test\LayerService\Objects\UsernameTest::testGetUsernameStringValue
     * @depends test\LayerService\Objects\PhavaTextTest::testGetTextStringValue
     * @depends test\LayerService\Objects\PhavaDatetimeTest::testGetDatetimeStringValue
     * @dataProvider messageProvider
     */
    public function testGetReceiverUserType(
        Id $messageIdObject,
        User $senderUserObject,
        User $receiverUserObject,
        PhavaText $bodyPhavaTextObject,
        PhavaDatetime $phavaDatetimeObject,
        bool $isReceived,
        Message $messageObject,
        Array $messageArray,
        bool $isResponse,
        ?Message $respondedToMessage
    )
    {
        $this->assertIsObject($messageObject->getReceiverUser());
    }

    /**
     * @depends test\LayerService\Objects\IdTest::testGetIdIntValue
     * @depends test\LayerService\ServiceModels\UserTest::testGetUsernameValue
     * @depends test\LayerService\Objects\UsernameTest::testGetUsernameStringValue
     * @depends test\LayerService\Objects\PhavaTextTest::testGetTextStringValue
     * @depends test\LayerService\Objects\PhavaDatetimeTest::testGetDatetimeStringValue
     * @dataProvider messageProvider
     */
    public function testGetReceiverUserValue(
        Id $messageIdObject,
        User $senderUserObject,
        User $receiverUserObject,
        PhavaText $bodyPhavaTextObject,
        PhavaDatetime $phavaDatetimeObject,
        bool $isReceived,
        Message $messageObject,
        Array $messageArray,
        bool $isResponse,
        ?Message $respondedToMessage
    )
    {
        $this->assertEquals($receiverUserObject, $messageObject->getReceiverUser());
    }

    /**
     * @depends test\LayerService\Objects\IdTest::testGetIdIntValue
     * @depends test\LayerService\ServiceModels\UserTest::testGetUsernameValue
     * @depends test\LayerService\Objects\UsernameTest::testGetUsernameStringValue
     * @depends test\LayerService\Objects\PhavaTextTest::testGetTextStringValue
     * @depends test\LayerService\Objects\PhavaDatetimeTest::testGetDatetimeStringValue
     * @dataProvider messageProvider
     */
    public function testGetBodyTextType(
        Id $messageIdObject,
        User $senderUserObject,
        User $receiverUserObject,
        PhavaText $bodyPhavaTextObject,
        PhavaDatetime $phavaDatetimeObject,
        bool $isReceived,
        Message $messageObject,
        Array $messageArray,
        bool $isResponse,
        ?Message $respondedToMessage
    )
    {
        $this->assertIsObject($messageObject->getBodyText());
    }

    /**
     * @depends test\LayerService\Objects\IdTest::testGetIdIntValue
     * @depends test\LayerService\ServiceModels\UserTest::testGetUsernameValue
     * @depends test\LayerService\Objects\UsernameTest::testGetUsernameStringValue
     * @depends test\LayerService\Objects\PhavaTextTest::testGetTextStringValue
     * @depends test\LayerService\Objects\PhavaDatetimeTest::testGetDatetimeStringValue
     * @dataProvider messageProvider
     */
    public function testGetBodyTextValue(
        Id $messageIdObject,
        User $senderUserObject,
        User $receiverUserObject,
        PhavaText $bodyPhavaTextObject,
        PhavaDatetime $phavaDatetimeObject,
        bool $isReceived,
        Message $messageObject,
        Array $messageArray,
        bool $isResponse,
        ?Message $respondedToMessage
    )
    {
        $this->assertEquals($bodyPhavaTextObject, $messageObject->getBodyText());
    }

    /**
     * @depends test\LayerService\Objects\IdTest::testGetIdIntValue
     * @depends test\LayerService\ServiceModels\UserTest::testGetUsernameValue
     * @depends test\LayerService\Objects\UsernameTest::testGetUsernameStringValue
     * @depends test\LayerService\Objects\PhavaTextTest::testGetTextStringValue
     * @depends test\LayerService\Objects\PhavaDatetimeTest::testGetDatetimeStringValue
     * @dataProvider messageProvider
     */
    public function testGetReceivedByBackendDatetimeType(
        Id $messageIdObject,
        User $senderUserObject,
        User $receiverUserObject,
        PhavaText $bodyPhavaTextObject,
        PhavaDatetime $phavaDatetimeObject,
        bool $isReceived,
        Message $messageObject,
        Array $messageArray,
        bool $isResponse,
        ?Message $respondedToMessage
    )
    {
        $this->assertIsObject($messageObject->getReceivedByBackendDatetime());
    }

    /**
     * @depends test\LayerService\Objects\IdTest::testGetIdIntValue
     * @depends test\LayerService\ServiceModels\UserTest::testGetUsernameValue
     * @depends test\LayerService\Objects\UsernameTest::testGetUsernameStringValue
     * @depends test\LayerService\Objects\PhavaTextTest::testGetTextStringValue
     * @depends test\LayerService\Objects\PhavaDatetimeTest::testGetDatetimeStringValue
     * @dataProvider messageProvider
     */
    public function testGetReceivedByBackendDatetimeValue(
        Id $messageIdObject,
        User $senderUserObject,
        User $receiverUserObject,
        PhavaText $bodyPhavaTextObject,
        PhavaDatetime $phavaDatetimeObject,
        bool $isReceived,
        Message $messageObject,
        Array $messageArray,
        bool $isResponse,
        ?Message $respondedToMessage
    )
    {
        $this->assertEquals($phavaDatetimeObject, $messageObject->getReceivedByBackendDatetime());
    }

    /**
     * @depends test\LayerService\Objects\IdTest::testGetIdIntValue
     * @depends test\LayerService\ServiceModels\UserTest::testGetUsernameValue
     * @depends test\LayerService\Objects\UsernameTest::testGetUsernameStringValue
     * @depends test\LayerService\Objects\PhavaTextTest::testGetTextStringValue
     * @depends test\LayerService\Objects\PhavaDatetimeTest::testGetDatetimeStringValue
     * @dataProvider messageProvider
     */
    public function testGetRespondedToMessageType(
        Id $messageIdObject,
        User $senderUserObject,
        User $receiverUserObject,
        PhavaText $bodyPhavaTextObject,
        PhavaDatetime $phavaDatetimeObject,
        bool $isReceived,
        Message $messageObject,
        Array $messageArray,
        bool $isResponse,
        ?Message $respondedToMessage
    )
    {
        if($isResponse)
        {
            $this->assertIsObject($messageObject->getRespondedToMessage());
        } else {
            $this->assertNull($messageObject->getRespondedToMessage());
        }
    }

    /**
     * @depends test\LayerService\Objects\IdTest::testGetIdIntValue
     * @depends test\LayerService\ServiceModels\UserTest::testGetUsernameValue
     * @depends test\LayerService\Objects\UsernameTest::testGetUsernameStringValue
     * @depends test\LayerService\Objects\PhavaTextTest::testGetTextStringValue
     * @depends test\LayerService\Objects\PhavaDatetimeTest::testGetDatetimeStringValue
     * @dataProvider messageProvider
     */
    public function testGetRespondedToMessageValue(
        Id $messageIdObject,
        User $senderUserObject,
        User $receiverUserObject,
        PhavaText $bodyPhavaTextObject,
        PhavaDatetime $phavaDatetimeObject,
        bool $isReceived,
        Message $messageObject,
        Array $messageArray,
        bool $isResponse,
        ?Message $respondedToMessage
    )
    {
        if($isResponse)
        {
            $this->assertEquals($respondedToMessage, $messageObject->getRespondedToMessage());
        } else {
            $this->assertNull($messageObject->getRespondedToMessage());
        }
    }

    /**
     * @depends test\LayerService\Objects\IdTest::testGetIdIntValue
     * @depends test\LayerService\ServiceModels\UserTest::testGetUsernameValue
     * @depends test\LayerService\Objects\UsernameTest::testGetUsernameStringValue
     * @depends test\LayerService\Objects\PhavaTextTest::testGetTextStringValue
     * @depends test\LayerService\Objects\PhavaDatetimeTest::testGetDatetimeStringValue
     * @dataProvider messageProvider
     */
    public function testGetIsResponseType(
        Id $messageIdObject,
        User $senderUserObject,
        User $receiverUserObject,
        PhavaText $bodyPhavaTextObject,
        PhavaDatetime $phavaDatetimeObject,
        bool $isReceived,
        Message $messageObject,
        Array $messageArray,
        bool $isResponse,
        ?Message $respondedToMessage
    )
    {
        $this->assertIsBool($messageObject->getIsResponse());
    }

    /**
     * @depends test\LayerService\Objects\IdTest::testGetIdIntValue
     * @depends test\LayerService\ServiceModels\UserTest::testGetUsernameValue
     * @depends test\LayerService\Objects\UsernameTest::testGetUsernameStringValue
     * @depends test\LayerService\Objects\PhavaTextTest::testGetTextStringValue
     * @depends test\LayerService\Objects\PhavaDatetimeTest::testGetDatetimeStringValue
     * @dataProvider messageProvider
     */
    public function testGetIsResponseValue(
        Id $messageIdObject,
        User $senderUserObject,
        User $receiverUserObject,
        PhavaText $bodyPhavaTextObject,
        PhavaDatetime $phavaDatetimeObject,
        bool $isReceived,
        Message $messageObject,
        Array $messageArray,
        bool $isResponse,
        ?Message $respondedToMessage
    )
    {
        $this->assertEquals($isResponse, $messageObject->getIsResponse());
    }

    /**
     * @depends test\LayerService\Objects\IdTest::testGetIdIntValue
     * @depends test\LayerService\ServiceModels\UserTest::testGetUsernameValue
     * @depends test\LayerService\Objects\UsernameTest::testGetUsernameStringValue
     * @depends test\LayerService\Objects\PhavaTextTest::testGetTextStringValue
     * @depends test\LayerService\Objects\PhavaDatetimeTest::testGetDatetimeStringValue
     * @dataProvider messageProvider
     */
    public function testGetIsRecievedType(
        Id $messageIdObject,
        User $senderUserObject,
        User $receiverUserObject,
        PhavaText $bodyPhavaTextObject,
        PhavaDatetime $phavaDatetimeObject,
        bool $isReceived,
        Message $messageObject,
        Array $messageArray,
        bool $isResponse,
        ?Message $respondedToMessage
    )
    {
        $this->assertIsBool($messageObject->getIsRecieved());
    }

    /**
     * @depends test\LayerService\Objects\IdTest::testGetIdIntValue
     * @depends test\LayerService\ServiceModels\UserTest::testGetUsernameValue
     * @depends test\LayerService\Objects\UsernameTest::testGetUsernameStringValue
     * @depends test\LayerService\Objects\PhavaTextTest::testGetTextStringValue
     * @depends test\LayerService\Objects\PhavaDatetimeTest::testGetDatetimeStringValue
     * @dataProvider messageProvider
     */
    public function testGetIsRecievedValue(
        Id $messageIdObject,
        User $senderUserObject,
        User $receiverUserObject,
        PhavaText $bodyPhavaTextObject,
        PhavaDatetime $phavaDatetimeObject,
        bool $isReceived,
        Message $messageObject,
        Array $messageArray,
        bool $isResponse,
        ?Message $respondedToMessage
    )
    {
        $this->assertEquals($isReceived, $messageObject->getIsRecieved());
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

        return [[
            $messageIdObject,
            $senderUserObject,
            $receiverUserObject,
            $bodyPhavaTextObject,
            $phavaDatetimeObject,
            $isReceived,
            $messageObject,
            $messageArray,
            false,
            null
        ],[
            $responseMessageIdObject,
            $senderUserObject,
            $receiverUserObject,
            $responseBodyPhavaTextObject,
            $responsePhavaDatetimeObject,
            $responseIsReceived,
            $responseMessageObject,
            $responseMessageArray,
            true,
            $messageObject
        ]];
    }

}

?>