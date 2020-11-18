<?php
namespace App\LayerNetwork\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\LayerNetwork\Controllers\Contracts\ControllerMessageContract;
use \App\LayerNetwork\Controllers\ControllerBase;
use \App\LayerNetwork\Helpers\HelperUser;
use \App\LayerRepository\Repositories\RepositoryMessage;
use \App\LayerService\Objects\PhavaException;

/**
 * @author Pouya
 */
class ControllerMessage extends ControllerBase implements ControllerMessageContract 
{
    /**
     * This function shows all the messages of the current user. This function
     * has pagination.
     * 
     * @return ResponseInterface
     */
    public function showAllMessagesOfCurrentUser()
    {
        $token = substr($this->request->getHeaderLine('Authorization'),7);
        $pageNumber = (int)$this->request->getHeaderLine('Page-Number');
        $pageSize = (int)$this->request->getHeaderLine('Page-Size');
        
        if(
            $token == null or 
            $pageNumber == null or 
            $pageNumber < 1 or
            $pageSize == null or
            $pageSize < 1
        )
        {
            $this->logger->warning(
                "Missing or bad data!",
                [
                    "token" => $token,
                    "pageNumber" => $pageNumber,
                    "pageSize" => $pageSize
                ]
            );
            return $this->badRequest("Missing or bad data!");
        }

        $userHelper = new HelperUser();
        $currentUser = $userHelper -> authenticateWithToken($token);

        if ($currentUser == null)
        {
            $this->logger->warning(
                "Unable to authorize user!",
                [
                    "token" => $token
                ]
            );
            return $this->unauthorized();
        }

        $messageRepository = new RepositoryMessage();
        $messages = $messageRepository->fetchMessagesOfUser(
            $currentUser,
            $pageNumber,
            $pageSize
        );

        return $this->responseFactory->generateResponse(
            $this->response,
            200,
            $this->jsonFactory->generateMessagesJson($messages),
            true
        );
    }

    /**
     * This function shows all the messages of the current user from the given user. 
     * This function has pagination.
     * 
     * @param int $senderId
     * 
     * @return ResponseInterface
     */
    public function showAllMessagesOfCurrentUserFromUser(string $senderUsername)
    {
        $token = substr($this->request->getHeaderLine('Authorization'),7);
        $pageNumber = (int)$this->request->getHeaderLine('Page-Number');
        $pageSize = (int)$this->request->getHeaderLine('Page-Size');

        if(
            $token == null or 
            $pageNumber == null or 
            $pageNumber < 1 or
            $pageSize == null or
            $pageSize < 1
        )
        {
            $this->logger->warning(
                "Missing or bad data!",
                [
                    "token" => $token,
                    "pageNumber" => $pageNumber,
                    "pageSize" => $pageSize
                ]
            );
            return $this->badRequest("Missing or bad data!");
        }

        $userHelper = new HelperUser();
        $currentUser = $userHelper -> authenticateWithToken($token);

        if ($currentUser == null)
        {
            $this->logger->warning(
                "Unable to authorize user!",
                [
                    "token" => $token
                ]
            );
            return $this->unauthorized();
        }

        $senderUser = $userHelper -> authenticateWithUsername($senderUsername);

        if ($senderUser == null)
        {
            $this->logger->warning(
                "Unable to authorize user!",
                [
                    "username" => $senderUsername
                ]
            );
            return $this->badRequest("Given user does not exist!");
        }

        $messageRepository = new RepositoryMessage();
        $messages = $messageRepository->fetchMessagesOfUserFromUser(
            $currentUser,
            $senderUser,
            $pageNumber,
            $pageSize
        );

        return $this->responseFactory->generateResponse(
            $this->response,
            200,
            $this->jsonFactory->generateMessagesJson($messages),
            true
        );
    }

    /**
     * This function inserts a message from current user to given receiver user.
     * It returns an empty Json if successful, else returns an error.
     * 
     * @param string $receiverUsername
     * @throws PhavaException
     */
    public function sendMessageTo(string $receiverUsername)
    {
        $token = substr($this->request->getHeaderLine('Authorization'),7);

        $userHelper = new HelperUser();
        $currentUser = $userHelper -> authenticateWithToken($token);

        if ($currentUser == null)
        {
            $this->logger->warning(
                "Unable to authorize user!",
                [
                    "token" => $token
                ]
            );
            return $this->unauthorized();
        }

        $receiverUser = $userHelper -> authenticateWithUsername($receiverUsername);

        if ($receiverUser == null)
        {
            $this->logger->warning(
                "Unable to authorize user!",
                [
                    "username" => $senderUsername
                ]
            );
            return $this->badRequest("Given user does not exist!");
        }

        $messageString = null;

        if(isset($this->request->getParsedBody()['Message'])) {
            $messageString = $this->request->getParsedBody()['Message'];
        }

        if ($messageString == null)
        {
            $this->logger->warning(
                "Null message!",
                null
            );
            return $this->badRequest('Null message!');
        }

        $responseToMessageId = null;

        if (
            isset($this->request->getParsedBody()['ResponseToMessage']) and 
            (int)$this->request->getParsedBody()['ResponseToMessage'] > 0) 
        {
            $responseToMessageId = (int)$this->request->getParsedBody()['ResponseToMessage'];
        }

        $messageRepository = new RepositoryMessage();

        $result = $messageRepository->insertMessagesFromUserToUser(
            $messageString,
            $responseToMessageId,
            $currentUser,
            $receiverUser
        );

        if($result) {
            return $this->responseFactory->generateResponse(
                $this->response,
                204,
                "",
                true
            );
        } else {
            throw new PhavaException("Couldn't send message.");
        }
    }
}
