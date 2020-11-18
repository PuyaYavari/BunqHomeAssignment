<?php
use \api\App;

require '../vendor/autoload.php';
require '../api/App.php';

$app = (new App())->get();
$app->run();

?>