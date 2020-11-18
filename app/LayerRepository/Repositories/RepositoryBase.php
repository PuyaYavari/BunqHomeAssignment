<?php
namespace App\LayerRepository\Repositories;

use \App\LayerRepository\Helpers\HelperDBConnections;
use \App\APILogger;

/**
 * @author Pouya Yavari
 */
class RepositoryBase{
    /**
     * @var PDO
     */
    protected $ChatDB;

    /**
     * @var APILogger
     */
    protected $logger;

    /**
     * Can be modified to take a parameter and connect to
     * a specific database based on that parameter.
     */
    public function __construct()
    {
        $this->logger = new APILogger();
        $this->ChatDB = HelperDBConnections::getPDOChatDB(); 
    }
}

?>