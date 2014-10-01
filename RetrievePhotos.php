<?php

if( isset($_GET['id']) ) {
    $id = $_GET['id'];
    
    if( file_exists('uploads/' . $id . '/') ) {
        $folder = opendir('uploads/' . $id . '/');
        $i = 0;
        
        while( false !== ($file = readdir($folder)) ) {
            
            if (($file != '.') && ($file != '..')) {
                $temp = explode('.', $file);
                echo '<div class="picture-box" id="' . $temp[0] . '">';
                echo '<a href="../wp-content/plugins/MyRealEstatePlugin/uploads/'.$_GET["id"].'/'.$file.'" data-lightbox="'.$temp[0].'" >
                <img src="../wp-content/plugins/MyRealEstatePlugin/uploads/'.$_GET["id"].'/'.$file.'">
                </a><br>';
                echo '</div>';               
            }
            $i++;
        }        
    }
    closedir($folder);
}