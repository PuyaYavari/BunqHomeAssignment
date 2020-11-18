<?php
namespace App\LayerService\ServiceModels\Contracts;

/**
 * @author Pouya
 */
interface ServiceUserContract
{
    public function getId();

    public function getName();

    public function getSurname();

    public function getUsername();

    public function canSendMessageTo(ServiceUserContract $receiver): bool;
}
?>