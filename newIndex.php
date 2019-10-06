<?php

// Setup error reporting
ini_set("display_errors", 1);
error_reporting(E_ALL);

// Setup autoloader
require './autoloader.php';

// Initialize main class
$app = new App();
echo $app->render();
