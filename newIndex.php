<?php
// Setup constants
require_once dirname(__FILE__) . '/App/Base/Modules/Startup/Constants.php';

// Setup autoloader
require_once(EXTERNAL . "/autoload.php");

$latte = new Latte\Engine;
new Intro\Intro();
