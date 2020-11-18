<?php declare(strict_types=1);

namespace test;

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

final class IntegrationTest extends TestCase
{
    protected $app;

    public function setUp(): void
    {
        $this->app = (new App())->get();
    }

    public function testMessageBeingSaved(){
        $env = Environment::mock();
        $senderUri = Uri::createFromString('/api/Messages/puyayavari');
        $receiverUri = Uri::createFromString('/api/Messages/oli');
        $headers = Headers::createFromEnvironment($env);
        $cookies = [];
        $serverParams = $env->all();
        $body = new RequestBody();
        $uploadedFiles = UploadedFile::createFromEnvironment($env);
        $senderToken = 'Bearer 4e77356e-fdc6-45b8-be95-c8fb669cabad';
        $receiverToken = 'Bearer c452116e-deea-4f42-be5d-01646a6f8980';
        $faker = Faker\Factory::create();
        $message = $faker->text(100);

        $request_POST_MESSAGE = new Request('POST', $senderUri, $headers, $cookies, $serverParams, $body, $uploadedFiles);
        $request_POST_MESSAGE = $request_POST_MESSAGE->withHeader('Authorization', $senderToken);
        $request_POST_MESSAGE = $request_POST_MESSAGE->withHeader('Content-Type', 'application/json');
        $request_POST_MESSAGE = $request_POST_MESSAGE->withMethod('POST');
        $request_POST_MESSAGE->getBody()->write(json_encode([ 'Message' => $message ]));

        $this->app->getContainer()['request'] = $request_POST_MESSAGE;
        
        $this->assertSame($this->app->run(true)->getStatusCode(), 204);

        $request_FETCH_200 = new Request('GET', $receiverUri, $headers, $cookies, $serverParams, $body, $uploadedFiles);
        $request_FETCH_200 = $request_FETCH_200->withHeader('Authorization', $receiverToken);
        $request_FETCH_200 = $request_FETCH_200->withHeader('Page-Number', '1');
        $request_FETCH_200 = $request_FETCH_200->withHeader('Page-Size', '5');
        $request_FETCH_200 = $request_FETCH_200->withMethod('GET');
        
        $this->app->getContainer()['request'] = $request_FETCH_200;
        $response = $this->app->run(true);

        $this->assertIsArray(json_decode($response->getBody()->__toString(), true));
        $this->assertStringContainsString($message, $response->getBody()->__toString());
    }
}

?>