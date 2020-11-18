<?php
namespace App\LayerRepository\Helpers;

ini_set('display_errors',1); 
error_reporting(E_ALL);

use PDO;
use \App\LayerService\Objects\PhavaException;
use \App\APILogger;

/**
 * You can use this class to connect to more than one DBs.
 * 
 * @author Pouya Yavari
 */
class HelperDBConnections{
    private static $testChatDB;

    /**
     * This function is used to connect to the database located in database folder.
     * This function returns an in-memory database when TEST_DB option is on.
     * 
     * @return PDO
     */
    public static function getPDOChatDB()
    {
        $logger = new APILogger();
        
        if(isset($GLOBALS['TEST_DB']) and $GLOBALS['TEST_DB'] == 'yes'){
            if(self::$testChatDB == null) {
                self::createTestChatDB();
            } else {
                $logger->debug("TestChatDB already exists.", null);
            }
            $logger->debug("Returning TestChatDB.", null);
            return self::$testChatDB;
        } else {
            return self::connectToChatDB();
        }
    }

    /**
     * Creates an in-memory ChatDB from the init.sql located in the projects root directory.
     */
    private static function createTestChatDB()
    {
        $logger = new APILogger();

        $logger->debug("Creating TestChatDB.", null);

        $testChatDB = new PDO('sqlite::memory:');

        if($testChatDB == null)
        {
            throw new PhavaException("Creating in-memory database failed!");
        }

        $logger->info("Created in-memory database.",null);

        $sql = file_get_contents("/app/init.sql");

        if ($testChatDB->exec($sql) != false){
            $logger->info("In-memory database ready.",null);
            self::$testChatDB = $testChatDB;
        }
        else {
            $logger->info("Failed to initialize in-memory database.",null);
        }
    }

    /**
     * Connects to and returns ChatDB.
     * 
     * @return PDO
     */
    private static function connectToChatDB()
    {
        $logger = new APILogger();

        $logger->debug("Connecting to database ChatDB.", null);

        $path = realpath('/app/database/ChatDB.db');
        $db = new PDO('sqlite:' . $path);

        if($db == null)
        {
            throw new PhavaException("database connection failed!");
        }

        $logger->info("database connection established.",["database"=>$path]);

        return $db;
    }
}
?>