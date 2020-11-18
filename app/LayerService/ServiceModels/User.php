<?php
namespace App\LayerService\ServiceModels;

use \App\LayerService\ServiceModels\Contracts\ServiceBaseModelContract;
use \App\LayerService\ServiceModels\Contracts\ServiceUserContract;
use \App\LayerService\Objects\Id;
use \App\LayerService\Objects\Fullname;
use \App\LayerService\Objects\Username;

/**
 * @author Pouya
 */
class User implements ServiceBaseModelContract, ServiceUserContract {

    /**
     * @var Id
     */
    protected $id;

    /**
     * @var Fullname
     */
    protected $fullname;

    /**
     * @var Username
     */
    protected $username;

    /**
     * @param Id $id
     * @param Fullname $fullname
     * @param Username $username
     */
    public function __construct(Id $id, Fullname $fullname, Username $username)
    {
        $this->id = $id;
        $this->fullname = $fullname;
        $this->username = $username;
    }

    /**
     * Returns an array containing models data.
     * 
     * @return array
     */
    public function getAsArray() : array
    {
        $userArray = array(
            "Id" => $this->id->getIdInt(),
            "Name" => $this->fullname->getName()->getNameString(),
            "Surname" => $this->fullname->getSurname()->getSurnameString(),
            "Username" => $this->username->getUsernameString()
        );

        return $userArray;
    }

    /**
     * @return Id
     */
    public function getId() 
    {
        return $this->id;
    }

    /**
     * @return Name
     */
    public function getName() 
    {
        return $this->fullname->getName();
    }

    /**
     * @return Surname
     */
    public function getSurname()
    {
        return $this->fullname->getSurname();
    }

    /**
     * @return Username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return bool
     */
    public function canSendMessageTo(ServiceUserContract $receiver): bool
    {
        if($this->id->getIdInt() == $receiver->getId()->getIdInt())
        {
            return false;
        } else {
            return true;
        }
    }
}

?>