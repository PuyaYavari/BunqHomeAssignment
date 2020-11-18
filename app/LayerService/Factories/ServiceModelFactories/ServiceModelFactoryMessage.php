<?php
namespace App\LayerService\Factories\ServiceModelFactories;

use \App\LayerService\Factories\ServiceModelFactories\Contracts\ServiceModelFactoryMessageContracts;
use \App\LayerService\Factories\ServiceModelFactories\ServiceModelFactoryBase;
use \App\LayerService\ServiceModels\Contracts\ServiceUserContract;
use \App\LayerService\ServiceModels\Contracts\ServiceMessageContract;
use \App\LayerService\ServiceModels\Message;
use \App\LayerService\Objects\Id;
use \App\LayerService\Objects\PhavaException;
use \App\LayerService\Objects\PhavaText;
use \App\LayerService\Objects\PhavaDatetime;

/**
 * @author Pouya
 */
class ServiceModelFactoryMessage extends ServiceModelFactoryBase implements ServiceModelFactoryMessageContracts
{
    /**
     * Error constants.
     */
    const ERROR_INPUT_INVALID = 'The provided input data are not valid.';

    /**
     * This function generates a service layer message model.
     * 
     * @param int $idInt
     * @param ServiceUserContract $senderUser
     * @param ServiceUserContract $receiverUser
     * @param string $bodyString
     * @param string $datetimeString
     * @param ServiceMessageContract $responseToMessage
     * @param bool $isReceived
     * 
     * @return ServiceMessageContract
     * @throws PhavaException
     */
    public function generateMessage(
        int $idInt,
        ServiceUserContract $senderUser,
        ServiceUserContract $receiverUser,
        string $bodyString,
        string $datetimeString,
        ?ServiceMessageContract $responseToMessage,
        bool $isReceived
    ): ServiceMessageContract
    {
        $id = new Id($idInt);
        $bodyText = new PhavaText($bodyString);
        $datetime = new PhavaDatetime($datetimeString);

        if($id != null and $bodyText != null and $datetime != null)
        {
            return new Message(
                $id,
                $senderUser, 
                $receiverUser, 
                $bodyText, 
                $datetime, 
                $responseToMessage, 
                $isReceived
            );
        } else {
            throw new PhavaException(self::ERROR_INPUT_INVALID);
        }
    }
}
?>