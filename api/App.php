<?php
namespace Api;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\LayerNetwork\Controllers\ControllerMessage;
use \App\APILogger;

/**
 * This class is used to make a slim application. This makes testing much easier.
 * 
 * @author Pouya
 */
class App{
    /**
     * @var
     */
    private $app;

    /**
     * This constructor cteates a Slim application and stores it in the app variable.
     */
    public function __construct(){
        $this->app = new \Slim\App();

        $this->setupErrorHandlers();

        $this->setupEndpoints();
    }

    /**
     * This function returns the created slim app.
     */
    public function get(){
        return $this->app;
    }

    /**
     * This function creates all the endpoints on the app. A router can be used here.
     */
    private function setupEndpoints() {
        $this->app->get('/api/Messages', function (Request $request, Response $response, array $args) {
            $logger = new APILogger();
            $logger->info(
                'Request arrived.', 
                [
                    'method'=>'GET', 
                    'endpoint'=>'/api/Messages'
                ]
            );
            
            $MessageController = new ControllerMessage($request, $response);
                return $MessageController -> showAllMessagesOfCurrentUser();
        });

        $this->app->get('/api/Messages/{username}', function (Request $request, Response $response, array $args) {
            $logger = new APILogger();
            $MessageController = new ControllerMessage($request, $response);
            $senderUsername = (string)$args['username'];

            $logger->info(
                'Request arrived.', 
                [
                    'method'=>'GET', 
                    'endpoint'=>'/api/Messages/{username}', 
                    'username'=>$senderUsername
                ]
            );
            
            if($senderUsername != null) {
                return $MessageController -> showAllMessagesOfCurrentUserFromUser($senderUsername);
            } else {
                $logger->error(
                    'Request lacks required data.', 
                    [
                        'method'=>'GET', 
                        'endpoint'=>'/api/Messages/{username}', 
                        'missing'=>'{username}'
                    ]
                );
            }
        });

        $this->app->post('/api/Messages/{username}', function (Request $request, Response $response, array $args) {
            $logger = new APILogger();

            $MessageController = new ControllerMessage($request, $response);
            $receiverUsername = (string)$args['username'];

            $logger->info(
                'Request arrived.', 
                [
                    'method'=>'POST', 
                    'endpoint'=>'/api/Messages/{username}',
                    'username'=>$receiverUsername
                ]
            );
            
            if($receiverUsername != null) {
                return $MessageController -> sendMessageTo($receiverUsername);
            } else {
                $logger->error(
                    'Request lacks required data.', 
                    [
                        'method'=>'GET', 
                        'endpoint'=>'/api/Messages/{username}', 
                        'missing'=>'{username}'
                    ]
                );
            }
        });
    }

    /**
     * This function overrides custom Slim and PHP error handlers.
     */
    private function setupErrorHandlers() {
        $container = $this->app->getContainer();

        $container['errorHandler'] = function ($c) {
            return function ($request, $response, $exception) use ($c) {
                $logger = new APILogger();
                $logger->exception($exception, null, null);
                return $c['response']->withStatus(500)
                                    ->withHeader('Content-Type', 'application/json')
                                    ->write('{"Error":"Something went wrong on our side, no system is perfect. ¯\_(ツ)_/¯"}');
            };
        };

        $container['phpErrorHandler'] = function ($c) {
            return function ($request, $response, $error) use ($c) {
                $logger = new APILogger();
                $logger->phpError($error, null, null);
                return $c['response']->withStatus(500)
                                    ->withHeader('Content-Type', 'application/json')
                                    ->write('{"Error":"Something went wrong on our side, no system is perfect. ¯\_(ツ)_/¯"}');
            };
        };
    }
}

?>