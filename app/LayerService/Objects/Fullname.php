<?php
namespace App\LayerService\Objects;

use App\LayerService\Objects\Name;
use App\LayerService\Objects\Surname;

/**
 * @author Pouya
 */
class Fullname
{
    /**
     * @var Name
     */
    protected $name;

    /**
     * @var Surname
     */
    protected $surname;

    /**
     * @param Name $name
     * @param Surname $surname
     */
    public function __construct(Name $name, Surname $surname)
    {
        $this->name = $name;
        $this->surname = $surname;
    }

    /**
     * @return Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Surname
     */
    public function getSurname()
    {
        return $this->surname;
    }
}

?>