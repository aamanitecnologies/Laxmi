<?php
error_reporting(E_ALL);

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$app = new \Slim\App;

require 'interface_users.php';
require 'interface_dashboard.php';
require 'interface_products.php';
require 'interface_parts.php';
require 'interface_uploads.php';


$app->run();
?>

