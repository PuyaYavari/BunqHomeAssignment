<?php
namespace App\LayerNetwork\Helpers;

use \App\LayerRepository\Repositories\RepositoryUser;

/**
 * @author Pouya Yavari
 */
class HelperUser{
    /**
     * @param int $id 
     * 
     * @return ServiceUserContract 
     */
    public function authenticateWithId(int $id) {
        $repoitoryUser = new RepositoryUser();
        return $repoitoryUser->getUserWithId($id);
    }

    /**
     * @param string $token 
     * 
     * @return ServiceUserContract 
     */
    public function authenticateWithToken(string $token) {
        $repoitoryUser = new RepositoryUser();
        return $repoitoryUser->getUserWithToken($token);
    }

    /**
     * @param string $username
     * 
     * @return ServiceUserContract 
     */
    public function authenticateWithUsername(string $username) {
        $repoitoryUser = new RepositoryUser();
        return $repoitoryUser->getUserWithUsername($username);
    }
}

?>