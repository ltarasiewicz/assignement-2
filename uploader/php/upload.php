<?php

if(isset($_FILES["myfile"]))
{
    
    $output_dir = "../../../../uploads/" .$_GET["id"] . "/";
    if (!file_exists($output_dir))
    {
        mkdir($output_dir, 0777, true);
    }
    $ret = array();

//	This is for custom errors;	
/*	$custom_error= array();
    $custom_error['jquery-upload-file-error']="File already exists";
    echo json_encode($custom_error);
    die();
*/
    $error =$_FILES["myfile"]["error"];
    //You need to handle  both cases
    //If Any browser does not support serializing of multiple files using FormData() 
    if(!is_array($_FILES["myfile"]["name"])) //single file
    {
            $ext = end(explode('.', $_FILES["myfile"]["name"]));
          
            $fileName = uniqid() . "." . $ext;
            $move = move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir . $fileName);
            json_encode(var_dump($move));
            var_dump($fileName);
    $ret[]= $fileName;
    }
    else  //Multiple files, file[]
    {
      $fileCount = count($_FILES["myfile"]["name"]);
      for($i=0; $i < $fileCount; $i++)
      {
            $ext = end(explode('.', $_FILES["myfile"]["name"]));
          
            $fileName = uniqid() . "." . $ext;
            move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir.$fileName);
            $ret[]= $fileName;
      }

    }
    echo json_encode($ret);
 }
 ?>