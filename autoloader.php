<?php
    spl_autoload_register(function($className){
        require dirname(__FILE__) . '/Classes/' . $className . ".class.php";
    })
?>
