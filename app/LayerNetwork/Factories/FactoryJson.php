<?php
namespace App\LayerNetwork\Factories;

use \App\LayerService\ServiceModels\Contracts\ServiceUserContract;
use \App\LayerService\ServiceModels\Contracts\ServiceMessageContract;

/**
 * @author Pouya
 */
class FactoryJson
{
    /**
     * This function takes and input string and generates an error Json
     * containing that string.
     * 
     * @param string $errorDescription
     * 
     * @return string
     */
    public function generateErrorJson(string $errorDescription)
    {
        return '{"Error":"' . $errorDescription . '"}';
    }

    /**
     * This function takes and input service model user and generates a 
     * Json string based on given user model.
     * 
     * @param ServiceUserContract $user
     * 
     * @return string
     */
    public function generateUserJson(ServiceUserContract $user)
    {
        return json_encode($user->getAsArray());
    }

    /**
     * This function takes an array of service model message and generates a 
     * Json string based on given message model.
     * 
     * @param array $messages
     * 
     * @return string
     */
    public function generateMessagesJson(array $messages)
    {
        $messagesArray = [];

        foreach($messages as $message)
        {
            array_push($messagesArray, $message->getAsArray());
        }

        return json_encode($messagesArray);
    }

    /**
     * This function takes a service model message and generates a 
     * Json string based on given message model.
     * 
     * @param ServiceMessageContract $message
     * 
     * @return string
     */
    public function generateMessageJson(ServiceMessageContract $message)
    {
        return json_encode($message->getAsArray());
    }
}

?>