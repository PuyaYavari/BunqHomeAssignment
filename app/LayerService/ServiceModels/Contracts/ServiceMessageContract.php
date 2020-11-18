<?php
namespace App\LayerService\ServiceModels\Contracts;

/**
 * @author Pouya
 */
interface ServiceMessageContract
{
    public function getId();

    public function getSenderUser();

    public function getReceiverUser();

    public function getBodyText();

    public function getReceivedByBackendDatetime();

    public function getRespondedToMessage();

    public function getIsResponse();

    public function getIsRecieved();
}
?>