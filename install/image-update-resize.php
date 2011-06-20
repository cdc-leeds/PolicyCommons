<?php

/**
 * Script to properly resize the images in the uploads directory
 */
include_once ("../config.php");

global $CFG;

$imgdir = dirname(dirname(__FILE__)).'/uploads/';

$handler = opendir($imgdir);

// keep going until all files in directory have been read
while ($file = readdir($handler)) {

    // if $file isn't this directory or its parent, 
    // add it to the results array
    if ($file != '.' && $file != '..'){
        $targetimg = $imgdir.$file;
        if(resize_image($targetimg,$targetimg,$CFG->IMAGE_WIDTH)){
             echo "resized: ". $targetimg. "<br/>";  
        } else {
            echo "error resizing: ". $targetimg. "<br/>"; 
        }
    }
}

// tidy up: close the handler
closedir($handler);

?>