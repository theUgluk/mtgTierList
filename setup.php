<?php
    function create_folder($folder){
        if(!file_exists($folder)){
            if(!mkdir($folder, 777)){
                exit("can't create folder: " . $folder);
            }
        }
    }
    create_folder("imgs");
    create_folder("typeCache");
?>
