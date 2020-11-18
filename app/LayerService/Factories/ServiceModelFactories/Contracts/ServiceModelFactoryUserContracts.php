<?php
namespace App\LayerService\Factories\ServiceModelFactories\Contracts;

use \App\LayerService\ServiceModels\Contracts\ServiceUserContract;

/**
 * @author Pouya
 */
interface ServiceModelFactoryUserContracts
{
    public function generateUser(
        int $idValue,
        string $nameString,
        string $surnameString,
        string $usernameString
    ): ServiceUserContract;
}

?>