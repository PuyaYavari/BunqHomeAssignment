<?php
namespace App\LayerService\Factories\ServiceModelFactories\Contracts;

use \App\LayerService\ServiceModels\Contracts\ServiceMessageContract;
use \App\LayerService\ServiceModels\Contracts\ServiceUserContract;

/**
 * @author Pouya
 */
interface ServiceModelFactoryMessageContracts
{
    public function generateMessage(
        int $idInt,
        ServiceUserContract $senderUser,
        ServiceUserContract $receiverUser,
        string $bodyString,
        string $datetimeString,
        ?ServiceMessageContract $responseToMessage,
        bool $isReceived
    ): ServiceMessageContract;
}

?>