<?php
namespace App\LayerNetwork\Factories;

use \Psr\Http\Message\ResponseInterface as Response;

/**
 * @author Pouya
 */
class FactoryResponse
{
    /**
     * This function takes the current response as a parameter and changes it based on the other
     * parameters provided to it and returns the newly created response.
     * 
     * @param Response $response
     * @param int $status
     * @param string $body
     * @param bool $isJson
     * 
     * @return ResponseInterface
     */
    public function generateResponse(Response $response, int $status, string $body, bool $isJson)
    {
        if($isJson)
        {
            $response = $response->withoutHeader('Content-type');
            $response = $response->withAddedHeader('Content-type', 'application/json');
        }

        $response = $response->withStatus($status);
        $response->getBody()->write($body);

        return $response;
    }
}

?>