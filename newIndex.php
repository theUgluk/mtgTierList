<?php
// Setup constants
require_once dirname(__FILE__) . '/App/Base/Modules/Startup/Constants.php';

// Setup autoloader
require_once(BASE . "/Modules/Autoloader/Autoloader.php");
new Intro\Intro();
