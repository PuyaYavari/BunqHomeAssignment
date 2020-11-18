<?php
namespace App\LayerService\ServiceModels;

use \App\LayerService\ServiceModels\Contracts\ServiceMessageContract;
use \App\LayerService\ServiceModels\Contracts\ServiceUserContract;
use \App\LayerService\ServiceModels\Contracts\ServiceBaseModelContract;
use \App\LayerService\Objects\Id;
use \App\LayerService\Objects\PhavaText;
use \App\LayerService\Objects\PhavaDatetime;

/**
 * @author Pouya
 */
class Message implements ServiceBaseModelContract, ServiceMessageContract
{
    /**
     * @var Id
     */
    protected $id;

    /**
     * @var ServiceUserContract
     */
    protected $senderUser;

    /**
     * @var ServiceUserContract
     */
    protected $receiverUser;

    /**
     * @var PhavaText
     */
    protected $bodyText;

    /**
     * @var PhavaDatetime
     */
    protected $receivedByBackendDatetime;

    /**
     * @var ServiceMessageContract
     */
    protected $responseToMessage;

    /**
     * @var bool
     */
    protected $isReceived;

    /**
     * @param Id $id
     * @param ServiceUserContract $senderUser
     * @param ServiceUserContract $receiverUser
     * @param PhavaText $bodyText
     * @param PhavaDatetime $receivedByBackendDatetime
     * @param ServiceMessageContract $responseToMessage
     * @param bool $isReceived
     */
    public function __construct(
        Id $id,
        ServiceUserContract $senderUser, 
        ServiceUserContract $receiverUser,
        PhavaText $bodyText,
        PhavaDatetime $receivedByBackendDatetime,
        ?ServiceMessageContract $responseToMessage,
        bool $isReceived
    )
    {
        $this->id = $id;
        $this->senderUser = $senderUser;
        $this->receiverUser = $receiverUser;
        $this->bodyText = $bodyText;
        $this->receivedByBackendDatetime = $receivedByBackendDatetime;
        if ($responseToMessage != null) 
        {
            $this->responseToMessage = $responseToMessage;
        }
        $this->isReceived = $isReceived;
    }

    /**
     * Returns an array containing models data.
     * 
     * @return array
     */
    public function getAsArray() : array
    {
        $responseToMessageBody = null;

        if (!is_null($this->responseToMessage))
        {
            $responseToMessageBody = $this->responseToMessage->getBodyText()->getTextString();
        }

        $messageArray = array(
            "Id" => $this->id->getIdInt(),
            "Sender" => $this->senderUser->getUsername()->getUsernameString(),
            "Receiver" => $this->receiverUser->getUsername()->getUsernameString(),
            "Body" => $this->bodyText->getTextString(),
            "ResponseTo" => $responseToMessageBody,
            "Time" => $this->receivedByBackendDatetime->getDatetimeString()
        );

        return $messageArray;
    }

    /**
     * @return Id
     */
    public function getId() 
    {
        return $this->id;
    }

    /**
     * @return ServiceUserContract
     */
    public function getSenderUser()
    {
        return $this->senderUser;
    }

    /**
     * @return ServiceUserContract
     */
    public function getReceiverUser()
    {
        return $this->receiverUser;
    }

    /**
     * @return PhavaText
     */
    public function getBodyText()
    {
        return $this->bodyText;
    }

    /**
     * @return PhavaDatetime
     */
    public function getReceivedByBackendDatetime()
    {
        return $this->receivedByBackendDatetime;
    }

    /**
     * @return ServiceMessageContract
     */
    public function getRespondedToMessage()
    {
        return $this->responseToMessage;
    }

    /**
     * @return bool
     */
    public function getIsResponse()
    {
        return $this->responseToMessage != null;
    }

    /**
     * @return bool
     */
    public function getIsRecieved()
    {
        return $this->isReceived;
    }
}
?>