<?php
namespace App\LayerNetwork\Controllers\Contracts;

/**
 * @author Pouya Yavari
 */
interface ControllerMessageContract
{
    public function showAllMessagesOfCurrentUser();

    public function showAllMessagesOfCurrentUserFromUser(string $senderUsername);

    public function sendMessageTo(string $receiverUsername);
}
?>