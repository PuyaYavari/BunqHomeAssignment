<?php
namespace App\LayerRepository\Repositories;

use \App\LayerRepository\Repositories\Contracts\RepositoryMessageContract;
use \App\LayerRepository\Repositories\RepositoryBase;
use \App\LayerRepository\Repositories\RepositoryUser;
use \App\LayerService\Factories\ServiceModelFactories\ServiceModelFactoryMessage;
use \App\LayerService\Factories\ServiceModelFactories\ServiceModelFactoryUser;
use \App\LayerService\ServiceModels\Contracts\ServiceUserContract;
use \App\LayerService\Objects\PhavaException;
use PDO;

/**
 * @author Pouya
 */
class RepositoryMessage extends RepositoryBase implements RepositoryMessageContract
{
    /**
     * This function retruns messages of the given user that are stored
     * in ChatDB, based on the given pagination inputs, as an array of 
     * service model message, reverse ordered by time.
     * 
     * @param ServiceUserContract $user
     * 
     * @return array
     */
    public function fetchMessagesOfUser(
        ServiceUserContract $user,
        int $pageNumber,
        int $pageSize
    )
    {
        $userId = $user->getId()->getIdInt();

        $result = 
            $this->ChatDB->query(
                "SELECT * 
                FROM Message 
                WHERE 
                    TO_USER = $userId AND 
                    VISIBLE = 1
                ORDER BY RECEIVED_BY_BACKEND_TIME DESC
                LIMIT $pageSize OFFSET ($pageNumber-1)*$pageSize"
            );
        if(!$result or empty($result)) {
            $this->logger->notice(
                "Empty query result. User " .
                $user->getUsername()->getUsernameString() .
                " has no more visible messages.",
                [
                    "Database"      => "ChatDB",
                    "pageNumber"    => $pageNumber,
                    "pageSize"      => $pageSize
                ]
            );
            return null;
        }else {
            $this->logger->debug(
                "Query successful. Fetched visible messages of user " . 
                $user->getUsername()->getUsernameString() .
                ".",
                [
                    "Database"      => "ChatDB",
                    "pageNumber"    => $pageNumber,
                    "pageSize"      => $pageSize
                ]
            );

            $result = $result->fetchall(PDO::FETCH_ASSOC);

            $messages = [];
            $userRepository = new RepositoryUser();

            $messageFactory = new ServiceModelFactoryMessage();
            
            foreach($result as $row) {
                $inResponseToMessage = null;
                if($row['RESPONSE_TO_MESSAGE_ID'] != null) 
                {
                    $inResponseToMessage =
                        $this->getMessageWithId((int)$row['RESPONSE_TO_MESSAGE_ID']);
                }

                $message = 
                    $messageFactory -> 
                    generateMessage (
                        (int)$row['ID'],
                        $userRepository->getUserWithId((int)$row['FROM_USER']),
                        $user,
                        (string)$row['BODY'],
                        (string)$row['RECEIVED_BY_BACKEND_TIME'],
                        $inResponseToMessage,
                        (bool)$row['RECEIVED'] == 1
                    );
                array_push($messages, $message);
            }
            return $messages;
        }
    }

    /**
     * This function retruns messages of the given user from the given senderUser 
     * that are stored in ChatDB, based on the given pagination inputs, as an 
     * array of service model message, reverse ordered by time.
     * 
     * @param ServiceUserContract $user
     * @param ServiceUserContract $senderUser
     * 
     * @return array
     */
    public function fetchMessagesOfUserFromUser(
        ServiceUserContract $user, 
        ServiceUserContract $senderUser,
        int $pageNumber,
        int $pageSize
    )
    {
        $userId = $user->getId()->getIdInt();
        $senderId = $senderUser->getId()->getIdInt();

        $result = 
            $this->ChatDB->query(
                "SELECT * 
                FROM Message 
                WHERE 
                    TO_USER = $userId AND 
                    FROM_USER = $senderId AND
                    VISIBLE = 1
                ORDER BY RECEIVED_BY_BACKEND_TIME DESC
                LIMIT $pageSize OFFSET ($pageNumber-1)*$pageSize"
                );

        if(!$result or empty($result)) {
            $this->logger->notice(
                "Empty query result! User " .
                $user->getUsername()->getUsernameString() .
                " has no more visible messages from " .
                $senderUser->getUsername()->getUsernameString() .
                ".",
                [
                    "Database"      => "ChatDB",
                    "pageNumber"    => $pageNumber,
                    "pageSize"      => $pageSize
                ]
            );
            return null;
        } else {
            $this->logger->debug(
                "Query successful. Fetched visible messages of user " . 
                $user->getUsername()->getUsernameString() .
                " from user " .
                $senderUser->getUsername()->getUsernameString() .
                ".",
                [
                    "Database"      => "ChatDB",
                    "pageNumber"    => $pageNumber,
                    "pageSize"      => $pageSize
                ]
            );

            $result = $result->fetchall(PDO::FETCH_ASSOC);
            
            $messages = [];
            $userRepository = new RepositoryUser();

            $messageFactory = new ServiceModelFactoryMessage();
            
            foreach($result as $row) {
                $inResponseToMessage = null;
                if($row['RESPONSE_TO_MESSAGE_ID'] != null) 
                {
                    $inResponseToMessage =
                        $this->getMessageWithId((int)$row['RESPONSE_TO_MESSAGE_ID']);
                }
                $message = 
                    $messageFactory -> 
                    generateMessage (
                        (int)$row['ID'],
                        $senderUser,
                        $user,
                        (string)$row['BODY'],
                        (string)$row['RECEIVED_BY_BACKEND_TIME'],
                        $inResponseToMessage,
                        (bool)$row['RECEIVED'] == 1
                    );
                array_push($messages, $message);
            }
            return $messages;
        }
    }

    /**
     * This function retruns the message with the given id from the given is stored 
     * in ChatDB, as a service model message.
     * 
     * @param int $id
     * 
     * @return ServiceMessageContract
     */
    protected function getMessageWithId(int $id)
    {
        $result = 
            $this->ChatDB->query(
                "SELECT * 
                FROM Message 
                WHERE ID = $id"
                );

        if(!$result or empty($result)) {
            $this->logger->notice(
                "Query failed!",
                [
                    "Database"      => "ChatDB",
                    "Id"            => $id
                ]
            );
            return null;
        } else {
            $result = $result->fetch(PDO::FETCH_ASSOC);

            if(empty($result)) {
                $this->logger->notice(
                    "Empty query result. No message with the given id.",
                    [
                        "Database"      => "ChatDB",
                        "Id"            => $id
                    ]
                );
                return null;
            }

            $this->logger->debug(
                "Query successful. Fetched message with the given id.",
                [
                    "Database"      => "ChatDB",
                    "Id"            => $id
                ]
            );
            
            $userRepository = new RepositoryUser();

            $messageFactory = new ServiceModelFactoryMessage();
            $message = 
                $messageFactory -> 
                generateMessage (
                    (int)$result['ID'],
                    $userRepository->getUserWithId((int)$result['FROM_USER']),
                    $userRepository->getUserWithId((int)$result['TO_USER']),
                    (string)$result['BODY'],
                    (string)$result['RECEIVED_BY_BACKEND_TIME'],
                    null,
                    (bool)$result['RECEIVED'] == 1
                );
            return $message;
        }
    }

    /**
     * This function takes a message string, and also sender and receiver users and
     * and inserts the message into the database. This function returns true if the
     * query runs successfuly, else returns false.
     * 
     * @param String $messageString
     * @param int $responseToMessageId
     * @param ServiceUserContract $user
     * @param ServiceUserContract $receiverUser
     * 
     * @return bool
     * @throws PhavaException
     */
    public function insertMessagesFromUserToUser(
        String $messageString, 
        ?int $responseToMessageId, 
        ServiceUserContract $user, 
        ServiceUserContract $receiverUser
    )
    {
        $sendeUserIdInt = $user->getId()->getIdInt();
        $receiverUserIdInt = $receiverUser->getId()->getIdInt();

        if (!$user->canSendMessageTo($receiverUser)) {
            $this->logger->warning(
                "Can't send message!",
                [
                    "sender"      => $user->getUsername()->getUsernameString(),
                    "receiver"  => $receiverUser->getUsername()->getUsernameString(),
                ]
            );
            return false;
        }

        $responseToMessage = null;

        if($responseToMessageId != null) {
            $responseToMessage = $this->getMessageWithId($responseToMessageId);
        }

        if ($responseToMessageId != null and $responseToMessage == null) {
            $this->logger->warning(
                "Response to uknown message!",
                [
                    "Database"      => "ChatDB",
                    "messageId" => $responseToMessageId
                ]
            );

            $responseToMessageId = null;
        }

        $query = $this->ChatDB->prepare(
            "INSERT INTO Message(
                FROM_USER,
                TO_USER,
                BODY,
                RESPONSE_TO_MESSAGE_ID
            ) VALUES (
                :sendeUserIdInt,
                :receiverUserIdInt,
                :messageString,
                :responseToMessageId
            )"
        );

        $query->bindValue(':sendeUserIdInt', $sendeUserIdInt, PDO::PARAM_INT);
        $query->bindValue(':receiverUserIdInt', $receiverUserIdInt, PDO::PARAM_INT);
        $query->bindValue(':messageString', $messageString, PDO::PARAM_STR);
        $query->bindValue(':responseToMessageId', $responseToMessageId, PDO::PARAM_INT);
    
        if($query->execute())
        {
            $this->logger->info(
                "Query successful. Inserted message from user " .
                $user->getUsername()->getUsernameString() .
                " to user " .
                $receiverUser->getUsername()->getUsernameString() .
                " into database.",
                [
                    "Database"              => "ChatDB",
                    "responseToMessageId"   => $responseToMessageId
                ]
            );
            return true;
        } else {
            throw new PhavaException("Couldn't insert message into database!");
        }
    }
}

?>