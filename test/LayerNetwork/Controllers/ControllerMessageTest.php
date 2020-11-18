<?php declare(strict_types=1);

namespace test\LayerNetwork\Controllers;

require_once '/app/api/App.php';

use Slim\Http\Environment;
use Slim\Http\Request;
use Slim\Http\Uri;
use Slim\Http\Headers;
use Slim\Http\RequestBody;
use Slim\Http\UploadedFile;
use \PHPUnit\Framework\TestCase;
use \App\LayerNetwork\Controllers\ControllerMessage;
use \api\App;
use Faker;

final class ControllerMessageTest extends TestCase
{
    protected $app;

    public function setUp(): void
    {
        $this->app = (new App())->get();
    }

    /**
     * @dataProvider showMessagesRequestProvider
     */
    public function testShowAllMessagesOfCurrentUser(Request $request, int $expectedStatus) {
        $this->app->getContainer()['request'] = $request;
        $response = $this->app->run(true);
        $this->assertSame($response->getStatusCode(), $expectedStatus);
    }
    

    public function showMessagesRequestProvider(){
        $env = Environment::mock();
        $uri_ALL = Uri::createFromString('/api/Messages');
        $uri_SINGLE_USER = Uri::createFromString('/api/Messages/puyayavari');
        $badUri = Uri::createFromString('/api/Messages/badUri');
        $headers = Headers::createFromEnvironment($env);
        $cookies = [];
        $serverParams = $env->all();
        $body = new RequestBody();
        $uploadedFiles = UploadedFile::createFromEnvironment($env);
        $validToken = 'Bearer 4e77356e-fdc6-45b8-be95-c8fb669cabad';
        
        $requests = [];

        $request_ALL_200 = new Request('GET', $uri_ALL, $headers, $cookies, $serverParams, $body, $uploadedFiles);
        $request_ALL_200 = $request_ALL_200->withHeader('Authorization', $validToken);
        $request_ALL_200 = $request_ALL_200->withHeader('Page-Number', '1');
        $request_ALL_200 = $request_ALL_200->withHeader('Page-Size', '5');
        $request_ALL_200 = $request_ALL_200->withMethod('GET');
        array_push($requests, [$request_ALL_200,200]);

        $request_ALL_400_1 = new Request('GET', $uri_ALL, $headers, $cookies, $serverParams, $body, $uploadedFiles);
        $request_ALL_400_1 = $request_ALL_400_1->withHeader('Authorization', $validToken);
        $request_ALL_400_1 = $request_ALL_400_1->withHeader('Page-Size', '5');
        $request_ALL_400_1 = $request_ALL_400_1->withMethod('GET');
        array_push($requests, [$request_ALL_400_1,400]);

        $request_ALL_400_2 = new Request('GET', $uri_ALL, $headers, $cookies, $serverParams, $body, $uploadedFiles);
        $request_ALL_400_2 = $request_ALL_400_2->withHeader('Authorization', $validToken);
        $request_ALL_400_2 = $request_ALL_400_2->withHeader('Page-Number', '1');
        $request_ALL_400_2 = $request_ALL_400_2->withMethod('GET');
        array_push($requests, [$request_ALL_400_2,400]);
        
        $request_ALL_400_3 = new Request('GET', $uri_ALL, $headers, $cookies, $serverParams, $body, $uploadedFiles);
        $request_ALL_400_3 = $request_ALL_400_3->withHeader('Page-Number', '1');
        $request_ALL_400_3 = $request_ALL_400_3->withHeader('Page-Size', '5');
        $request_ALL_400_3 = $request_ALL_400_3->withMethod('GET');
        array_push($requests, [$request_ALL_400_3,400]);
        
        $request_ALL_401 = new Request('GET', $uri_ALL, $headers, $cookies, $serverParams, $body, $uploadedFiles);
        $request_ALL_401 = $request_ALL_401->withHeader('Authorization', 'Bearer bad token');
        $request_ALL_401 = $request_ALL_401->withHeader('Page-Number', '1');
        $request_ALL_401 = $request_ALL_401->withHeader('Page-Size', '5');
        $request_ALL_401 = $request_ALL_401->withMethod('GET');
        array_push($requests, [$request_ALL_401,401]);

        $request_SINGLE_USER_200 = new Request('GET', $uri_SINGLE_USER, $headers, $cookies, $serverParams, $body, $uploadedFiles);
        $request_SINGLE_USER_200 = $request_SINGLE_USER_200->withHeader('Authorization', $validToken);
        $request_SINGLE_USER_200 = $request_SINGLE_USER_200->withHeader('Page-Number', '1');
        $request_SINGLE_USER_200 = $request_SINGLE_USER_200->withHeader('Page-Size', '5');
        $request_SINGLE_USER_200 = $request_SINGLE_USER_200->withMethod('GET');
        array_push($requests, [$request_SINGLE_USER_200,200]);

        $request_SINGLE_USER_400_1 = new Request('GET', $uri_SINGLE_USER, $headers, $cookies, $serverParams, $body, $uploadedFiles);
        $request_SINGLE_USER_400_1 = $request_SINGLE_USER_400_1->withHeader('Authorization', $validToken);
        $request_SINGLE_USER_400_1 = $request_SINGLE_USER_400_1->withHeader('Page-Size', '5');
        $request_SINGLE_USER_400_1 = $request_SINGLE_USER_400_1->withMethod('GET');
        array_push($requests, [$request_SINGLE_USER_400_1,400]);

        $request_SINGLE_USER_400_2 = new Request('GET', $uri_SINGLE_USER, $headers, $cookies, $serverParams, $body, $uploadedFiles);
        $request_SINGLE_USER_400_2 = $request_SINGLE_USER_400_2->withHeader('Authorization', $validToken);
        $request_SINGLE_USER_400_2 = $request_SINGLE_USER_400_2->withHeader('Page-Number', '1');
        $request_SINGLE_USER_400_2 = $request_SINGLE_USER_400_2->withMethod('GET');
        array_push($requests, [$request_SINGLE_USER_400_2,400]);
        
        $request_SINGLE_USER_400_3 = new Request('GET', $uri_SINGLE_USER, $headers, $cookies, $serverParams, $body, $uploadedFiles);
        $request_SINGLE_USER_400_3 = $request_SINGLE_USER_400_3->withHeader('Page-Number', '1');
        $request_SINGLE_USER_400_3 = $request_SINGLE_USER_400_3->withHeader('Page-Size', '5');
        $request_SINGLE_USER_400_3 = $request_SINGLE_USER_400_3->withMethod('GET');
        array_push($requests, [$request_SINGLE_USER_400_3,400]);
        
        $request_SINGLE_USER_400_4 = new Request('GET', $badUri, $headers, $cookies, $serverParams, $body, $uploadedFiles);
        $request_SINGLE_USER_400_4 = $request_SINGLE_USER_400_4->withHeader('Authorization', $validToken);
        $request_SINGLE_USER_400_4 = $request_SINGLE_USER_400_4->withHeader('Page-Number', '1');
        $request_SINGLE_USER_400_4 = $request_SINGLE_USER_400_4->withHeader('Page-Size', '5');
        $request_SINGLE_USER_400_4 = $request_SINGLE_USER_400_4->withMethod('GET');
        array_push($requests, [$request_SINGLE_USER_400_4,400]);
        
        $request_SINGLE_USER_401 = new Request('GET', $uri_SINGLE_USER, $headers, $cookies, $serverParams, $body, $uploadedFiles);
        $request_SINGLE_USER_401 = $request_SINGLE_USER_401->withHeader('Authorization', 'Bearer bad token');
        $request_SINGLE_USER_401 = $request_SINGLE_USER_401->withHeader('Page-Number', '1');
        $request_SINGLE_USER_401 = $request_SINGLE_USER_401->withHeader('Page-Size', '5');
        $request_SINGLE_USER_401 = $request_SINGLE_USER_401->withMethod('GET');
        array_push($requests, [$request_SINGLE_USER_401,401]);

        $request_POST_MESSAGE_204_1 = new Request('POST', $uri_SINGLE_USER, $headers, $cookies, $serverParams, $body, $uploadedFiles);
        $request_POST_MESSAGE_204_1 = $request_POST_MESSAGE_204_1->withHeader('Authorization', $validToken);
        $request_POST_MESSAGE_204_1 = $request_POST_MESSAGE_204_1->withHeader('Content-Type', 'application/json');
        $request_POST_MESSAGE_204_1 = $request_POST_MESSAGE_204_1->withMethod('POST');
        $request_POST_MESSAGE_204_1->getBody()->write(json_encode([ 'Message' => 'test message' ]));
        array_push($requests, [$request_POST_MESSAGE_204_1,204]);

        return $requests;
    }
}

?>