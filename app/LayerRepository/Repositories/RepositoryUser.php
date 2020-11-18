<?php
namespace App\LayerRepository\Repositories;

use \App\LayerRepository\Repositories\Contracts\RepositoryUserContract;
use \App\LayerRepository\Repositories\RepositoryBase;
use \App\LayerService\Factories\ServiceModelFactories\ServiceModelFactoryUser;
use \App\LayerService\Objects\PhavaException;
use PDO;

/**
 * @author Pouya Yavari
 */
class RepositoryUser extends RepositoryBase implements RepositoryUserContract
{
    /**
     * This fuction returns a service layer user if any active user with given id exists 
     * else it returns null.
     * 
     * @param int $userId
     * 
     * @return ServiceUserContract
     */
    public function getUserWithId(int $userId)
    {
        $result = $this->ChatDB->query(
            "SELECT * 
            FROM User 
            WHERE ID = $userId AND ACTIVE = 1"
        );

        if(!$result or empty($result)) {
            $this->logger->notice(
                "Query failed!",
                [
                    "Database"      => "ChatDB",
                    "Id"            => $userId
                ]
            );
            return null;
        } else {
            $result = $result->fetch(PDO::FETCH_ASSOC);

            if(empty($result))
            {
                $this->logger->notice(
                    "Empty query result. No active user with the given id!",
                    [
                        "Database"      => "ChatDB",
                        "Id"            => $userId
                    ]
                );
                return null;
            }

            $this->logger->debug(
                "Query successful. Fetched user with the given id.",
                [
                    "Database"      => "ChatDB",
                    "Id"            => $userId
                ]
            );

            $userFactory = new ServiceModelFactoryUser();
            $user = 
                $userFactory -> 
                generateUser (
                    (int)$result['ID'],
                    (string)$result['NAME'],
                    (string)$result['SURNAME'],
                    (string)$result['USERNAME'] 
                );
            return $user;
        }
    }

    /**
     * This fuction returns a service layer user if any active user with given token exists 
     * else it returns null.
     * 
     * @param string $userToken
     * 
     * @return ServiceUserContract
     */
    public function getUserWithToken(string $userToken)
    {
        $result = $this->ChatDB->query(
            "SELECT * 
            FROM User 
            WHERE TOKEN Like '$userToken' AND ACTIVE = 1"
        );

        if(!$result or empty($result)) {
            $this->logger->notice(
                "Query failed!",
                [
                    "Database"      => "ChatDB"
                ]
            );
            return null;
        } else {
            $result = $result->fetch(PDO::FETCH_ASSOC);

            if(empty($result)) {
                $this->logger->notice(
                    "Empty query result. No active user with the given token!",
                    [
                        "Database"      => "ChatDB"
                    ]
                );
                return null;
            }

            $this->logger->debug(
                "Query successful. Fetched user with the given token.",
                [
                    "Database"      => "ChatDB"
                ]
            );
        
            $userFactory = new ServiceModelFactoryUser();
            $user = 
                $userFactory -> 
                generateUser (
                    (int)$result['ID'],
                    (string)$result['NAME'],
                    (string)$result['SURNAME'],
                    (string)$result['USERNAME'] 
                );
            return $user;
        }
    }

    /**
     * This fuction returns a service layer user if any active user with given username exists 
     * else it returns null.
     * 
     * @param string $userUsername
     * 
     * @return ServiceUserContract
     */
    public function getUserWithUsername(string $userUsername)
    {
        $result = $this->ChatDB->query(
            "SELECT * 
            FROM User 
            WHERE USERNAME Like '$userUsername' AND ACTIVE = 1"
        );

        if(!$result or empty($result)) {
            $this->logger->notice(
                "Query failed!",
                [
                    "Database"      => "ChatDB",
                    "username"      => $userUsername
                ]
            );
            return null;
        } else {
            $result = $result->fetch(PDO::FETCH_ASSOC);
        
            if(empty($result)) {
                $this->logger->notice(
                    "Empty query result. No active user with the given username!",
                    [
                        "Database"      => "ChatDB",
                        "username"      => $userUsername
                    ]
                );
                return null;
            }

            $this->logger->debug(
                "Query successful. Fetched user with the given username.",
                [
                    "Database"      => "ChatDB",
                    "username"      => $userUsername
                ]
            );

            $userFactory = new ServiceModelFactoryUser();
            $user = 
                $userFactory -> 
                generateUser (
                    (int)$result['ID'],
                    (string)$result['NAME'],
                    (string)$result['SURNAME'],
                    (string)$result['USERNAME'] 
                );
            return $user;
        }
    }
}

?> 