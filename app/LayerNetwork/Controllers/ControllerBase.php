<?php
namespace App\LayerNetwork\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\LayerNetwork\Factories\FactoryJson;
use \App\LayerNetwork\Factories\FactoryResponse;
use \App\APILogger;

/**
 * @author Pouya
 */
class ControllerBase
{
    /**
     * @var ServerRequestInterface
     */
    protected $request;

    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var FactoryResponse
     */
    protected $responseFactory;

    /**
     * @var FactoryJson
     */
    protected $jsonFactory;

    /**
     * @var APILogger
     */
    protected $logger;

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->logger = new APILogger();

        $this->request = $request;
        $this->response = $response;
        $this->responseFactory = new FactoryResponse();
        $this->jsonFactory = new FactoryJson();
    }

    /**
     * This function generates and returns a 400 BadRequest response. A message can be added
     * to the response body. 
     * 
     * @param string $message
     * 
     * @return ResponseInterface
     */
    protected function badRequest(string $message)
    {
        return $this->responseFactory->generateResponse(
            $this->response,
            400,
            $this->jsonFactory->generateErrorJson($message),
            true
        );
    }

    /**
     * This function generates and returns a 401 user unauthorized response.
     * 
     * @return ResponseInterface
     */
    protected function unauthorized()
    {
        return $this->responseFactory->generateResponse(
            $this->response,
            401,
            $this->jsonFactory->generateErrorJson('Unauthorized!'),
            true
        );
    }
}

?>