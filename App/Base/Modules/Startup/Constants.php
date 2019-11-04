<?php
  //Set current working directory to  URL (/) of project
  chdir(dirname(__FILE__) . "/../../../");

  //Define some basic URI's
  define("APP", getcwd());
  define("BASE", APP . "/Base/");

  //Composer vendor folder
  define("EXTERNAL", dirname(getcwd() . "../") . "/vendor/");
?>
