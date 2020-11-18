<?php
namespace App\LayerService\Factories\ServiceModelFactories;

use \App\LayerService\Factories\ServiceModelFactories\Contracts\ServiceModelFactoryUserContracts;
use \App\LayerService\Factories\ServiceModelFactories\ServiceModelFactoryBase;
use \App\LayerService\ServiceModels\Contracts\ServiceUserContract;
use \App\LayerService\ServiceModels\User;
use \App\LayerService\Objects\Id;
use \App\LayerService\Objects\Name;
use \App\LayerService\Objects\Surname;
use \App\LayerService\Objects\Fullname;
use \App\LayerService\Objects\Username;
use \App\LayerService\Objects\PhavaException;

/**
 * @author Pouya
 */
class ServiceModelFactoryUser extends ServiceModelFactoryBase implements ServiceModelFactoryUserContracts
{
    /**
     * Error constants.
     */
    const ERROR_INPUT_INVALID = 'The provided input data are not valid.';

    /**
     * This function generates a service layer user model.
     * 
     * @param int $idValue
     * @param string $nameString
     * @param string $surnameString
     * @param string $usernameString
     * 
     * @return ServiceUserContract
     * @throws PhavaException
     */
    public function generateUser(
        int $idValue,
        string $nameString,
        string $surnameString,
        string $usernameString
    ): ServiceUserContract
    {
        $idObject = new Id($idValue);
        $nameObject = new Name($nameString);
        $surnameObject = new Surname($surnameString);
        $fullnameObject = new Fullname($nameObject, $surnameObject);
        $usernameObject = new Username($usernameString);
        
        if($idObject != null and $fullnameObject != null and $usernameObject != null)
        {
            return new User($idObject, $fullnameObject, $usernameObject);
        } else {
            throw new PhavaException(self::ERROR_INPUT_INVALID);
        }
    }
}

?>