<?php
require("database.php");

$db = new MyPhoto();
$mode = $_POST['mode'];
if ($mode == "albums") {
    $db->get_albums();
    if($db->getNumRow() == 0){
        echo "{\"noAlbum\": \"true\"}";
    }else{
        $tem = "[";
        while ($row = $db->getResult("object")){
            $tem.="{\"name\":\"".$row->name."\"}";
        }
        $tem.="]";
        echo $tem;
    }
}
