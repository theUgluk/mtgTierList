<?php

spl_autoload_register(function($className){

  // List of starting points to search for classes
  // @TODO would love to have this seperated from the function, not sure how tho
  $baseFolders = array(
    APP,
    BASE
  );

  //Split up namespace
  $parts = explode('\\', $className);

  //Generate a URI from the parts of the namespace
  $path = "";
  foreach($parts as $part){
    $path .= ucfirst("/" . $part);
  }

  // Add php suffix
  $path .= ".php";

  // Check if the phpfile exists
  foreach($baseFolders as $folder){
    // If it does, include it
    if(file_exists($folder . $path)){
      require_once($folder . $path);
      return;
    }
  }
  // @TODO error handling for a decent page?
  throw new Exception("File not found");
});
?>
