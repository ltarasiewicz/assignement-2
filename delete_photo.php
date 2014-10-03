<?php
if ( isset($_POST['name']) && isset($_POST['id']) ) {
    
    chmod("../../plugins/MyRealEstatePlugin/uploads/". $_POST["id"]."/". $_POST['name'], 0777);
    $address = "../../plugins/MyRealEstatePlugin/uploads/". $_POST["id"]."/". $_POST['name'];
    unlink($address);
}