<?php

// Setup autoloader
require './autoloader.php';

// Initialize main class
$app = new App();
echo $app->render();
