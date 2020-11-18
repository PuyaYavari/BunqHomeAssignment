<?php
namespace App\LayerRepository\Repositories\Contracts;

use \App\LayerService\ServiceModels\Contracts\ServiceUserContract;

/**
 * @author Pouya Yavari
 */
interface RepositoryMessageContract
{
    public function fetchMessagesOfUser(
        ServiceUserContract $user,
        int $pageNumber,
        int $pageSize
    );

    public function fetchMessagesOfUserFromUser(
        ServiceUserContract $user, 
        ServiceUserContract $sendeUser,
        int $pageNumber,
        int $pageSize
    );

    public function insertMessagesFromUserToUser(
        String $messageString, 
        ?int $responseToMessageId, 
        ServiceUserContract $user, 
        ServiceUserContract $receiverUser
    );
}

?>