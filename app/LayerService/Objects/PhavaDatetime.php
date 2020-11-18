<?php
namespace App\LayerService\Objects;

use \Datetime;

/**
 * @author Pouya
 */
class PhavaDatetime
{
    /**
     * @var DateTime
     */
    protected $datetime;

    /**
     * This constructor takes datetime data as string and converts it into PHP datetime.
     * 
     * @param string
     */
    public function __construct(string $datetime)
    {
        $this->datetime = new DateTime($datetime);
    }

    /**
     * @return DateTime
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * @return string
     */
    public function getDatetimeString()
    {
        return $this->datetime->format('Y-m-d H:i:s');
    }
}

?>