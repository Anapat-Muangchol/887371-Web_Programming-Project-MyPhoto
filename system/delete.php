<?php
require("database.php");
$db = new MyPhoto();
$mode = $_POST['mode'];
if(isset($_GET['mode']))$mode = $_GET['mode'];



if($mode == "photo"){
    $id = $_GET['id'];
    if(isset($id)){
        $db->delete_photos_by_idPhoto($id);
        echo "<div id=\"alert\" style='display: none; text-align: center' class=\"alert alert-default\"><h5 style='color: red;'><i class=\"fa fa-trash\" aria-hidden=\"true\"></i>&nbsp;&nbsp;Delete photo successfully.</h5><button type=\"button\" class=\"close\" data-dismiss=\"modal\"></button></div>";
    }
    echo "<script>
    $(\"#alert\").fadeIn(500);
    setTimeout(function () {
        $(document).ready(function() {";

    if($_GET['albums_id']=="")echo "$(\"#showPhoto\").load(\"factor/showPhoto.php\");";
    else echo "$(\"#showAlbums\").load(\"factor/showPhotoInAlbum.php?id=".$_GET['albums_id']."\");";
    echo "  $('.close').trigger('click');
        });
    }, 1500);
    </script>";
}




if($mode == "album"){
    $id = $_GET['id'];
    if(isset($id)){
        $db->delete_album_by_albums_id($id);
        echo "<div id=\"alert\" style='display: none; text-align: center' class=\"alert alert-default\"><h5 style='color: red;'><i class=\"fa fa-trash\" aria-hidden=\"true\"></i>&nbsp;&nbsp;Delete this album successfully.</h5></div>";
    }
    echo "<script>
    $(\"#alert\").fadeIn(500);
    setTimeout(function () {
        $(document).ready(function() {
            $(\"#showAlbums\").load(\"factor/showAlbums.php\");
            $(\"#showPhoto\").load(\"factor/showPhoto.php\");
        });
    }, 1500);
    </script>";
}







if($mode == "album-And-PhotoInAlbum") {
    $id = $_GET['id'];
    if (isset($id)) {
        $db->delete_album_and_photos_by_albums_id($id);
        echo "<div id=\"alert\" style='display: none; text-align: center' class=\"alert alert-default\"><h5 style='color: red;'><i class=\"fa fa-trash\" aria-hidden=\"true\"></i>&nbsp;&nbsp;Delete photos and album successfully.</h5></div>";
    }
    echo "<script>
    $(\"#alert\").fadeIn(500);
    setTimeout(function () {
        $(document).ready(function() {
            $(\"#showAlbums\").load(\"factor/showAlbums.php\");
        });
    }, 1500);
    </script>";

}
?>