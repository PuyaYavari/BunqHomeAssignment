<?php
namespace App\LayerRepository\Repositories\Contracts;

/**
 * @author Pouya Yavari
 */
interface RepositoryUserContract
{
    public function getUserWithId(int $userId);

    public function getUserWithToken(string $userToken);

    public function getUserWithUsername(string $userUsername);
}

?>