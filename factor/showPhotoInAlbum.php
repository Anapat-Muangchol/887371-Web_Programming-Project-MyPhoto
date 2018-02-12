<?php session_start();
require("../system/database.php");
$db = new MyPhoto();
$albums_id = $_GET['id'];
$db->get_albums_by_albums_id($albums_id);
$row = $db->getResult("object");
$name = $row->name;
$description = $row->description;
$dateCreate = $row->dateCreate;
$dateEdit = $row->dateEdit;

$db->get_photos_by_albums($albums_id);
?>

<div class="row">
    <div class="col-md-1 col-xs-0"></div>
    <div class="col-md-10 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading" id="header-showPhotoInAlbum">
                <div class="form-group" style="text-align: center;">
                    <div class="row">
                        <div class="col-md-2 col-xs-6">
                            <button id="btn_back_in_newAlbum" class="btn btn-default btn-md pull-left"
                                    style="background-color: white;">
                                <i class="fa fa-chevron-circle-left" aria-hidden="true"></i>&nbsp;&nbsp;Back
                            </button>
                        </div>
                        <div class="col-md-2 col-xs-6 pull-right">
                            <span id="btn_edit_delete_in_showAlbum">
                                <button id="btn_edit_in_newAlbum" class="btn btn-warning btn-md pull-right">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;&nbsp;Edit
                                </button>
                            </span>
                        </div>
                        <div class="col-md-8 col-xs-12">
                            <h3><i class="fa fa-picture-o" aria-hidden="true"></i>&nbsp;&nbsp;<b><?php echo $name; ?>
                                    album</b>&nbsp;&nbsp;<span
                                    class='badge'><?php echo $db->getNumRow(); ?></span></h3>
                            <small>
                                Created on <?php echo $dateCreate;
                                if ($dateEdit != "") echo "<br>Edited on " . $dateEdit;
                                ?>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <div class="row" id="editAlbum">
                        <?php
                        if($description != "")echo "<div class=\"col-md-12 col-xs-12\"><label for=\"newAlbum_description\">Description &nbsp;:&nbsp;<h5 style=\"display: inline;\">".$description."</h5></label><hr></div>";
                        ?>
                    </div>
                    <?php
                    $numRow = $db->getNumRow();
                    if ($numRow == 0) echo "<div style='width: 100%; text-align: center;'><h4>No photo</h4></div>";

                    $cnt = 0;
                    while ($row = $db->getResult("object")) {
                        if ($cnt == 0) echo "<div class=\"row\">";
                        echo "<div class=\"col-md-3 col-xs-6\">
                                    <a id='photoData' data-toggle=\"modal\" data-target=\"#myModal\" class=\"thumbnail\" href=\"factor/showPhotoData.php?id=" . $row->id . "&albums_id=" . $albums_id . "\">";
                        echo "<img src=\"uploads/" . $row->nameReal . "\" style=\"max-width:100%;max-height:100%;\">";
                        echo "      <h4 style=\"text-align: center\">" . $row->nameShow . "</h4>
                                    </a>
                                </div>";
                        $numRow--;
                        $cnt++;
                        if ($cnt >= 4 || $numRow == 0) {
                            echo "</div>";
                            $cnt = 0;
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="panel-footer clearfix">
                <button class="btn btn-info btn-md pull-right" id="btnUploadOnShowPhotoInAlbum"><i
                        class="fa fa-cloud-upload" aria-hidden="true"></i>&nbsp;&nbsp;Uploads
                </button>
                <input type="hidden" name="dataPhotos001">
            </div>
        </div>
    </div>
    <div class="col-md-1 col-xs-0"></div>
</div>


<script>

    $(document).ready(function () {

        $('a#photoData').click(function (e) {
            e.preventDefault();
            var urlThis = $(this).attr('href');
            //alert(urlThis);
            $('#myModal').load(urlThis);
        });

        $('#btn_back_in_newAlbum').click(function () {
            $("#showAlbums").fadeTo(500, 0, function () {
                $("#showAlbums").load('factor/showAlbums.php', function () {
                    $("#showAlbums").fadeTo(500, 1);
                })
            });
        });

        $('#btn_edit_in_newAlbum').click(function () {
            $("#editAlbum").fadeTo(500, 0, function () {
                $("#editAlbum").load('factor/editAlbum.php?id=<?php echo $albums_id;?>', function () {
                    $("#editAlbum").fadeTo(500, 1);
                })
            });
            $("#btn_edit_delete_in_showAlbum").fadeTo(500, 0, function () {
                var btn = "<button id='btn_delete_in_editAlbum' class='btn btn-danger pull-right'><i class='fa fa-trash-o' aria-hidden='true'></i>&nbsp;&nbsp;Delete album </button>";
                $("#btn_edit_delete_in_showAlbum").html(btn, function () {
                    $("#btn_edit_delete_in_showAlbum").fadeTo(500, 1);
                })
            });
        });

        $('#btn_edit_delete_in_showAlbum').on('click', '#btn_delete_in_editAlbum', function () {
            var r = confirm("Are you sure to delete this album?");
            if (r == true) {
                var r = confirm("Do you want to delete photos in the album and this album?");
                if (r == true) {
                    var urlDel = "system/delete.php?mode=album-And-PhotoInAlbum&id=<?php echo $albums_id;?>";
                    $('#showAlbums').load(urlDel);
                }else{
                    var urlDel = "system/delete.php?mode=album&id=<?php echo $albums_id;?>";
                    $('#showAlbums').load(urlDel);
                }
            }
        });

        $("#btnUploadOnShowPhotoInAlbum").click(function () {
            $("#addPhoto").fadeTo(200, 0, function () {
                $('html, body').animate({scrollTop: 0}, 300, function () {
                    var urlTem = "factor/addPhoto.php?albums_id=<?php echo $albums_id;?>";
                    //alert(urlTem);
                    $("#addPhoto").load(urlTem, function () {
                        $("#addPhoto").fadeTo(200, 1);
                    })
                });
            });
        });
    });
    /*
     $("#showPicture").on("click", "#uploadButtonInShowPicture", function(){
     $('html, body').animate({scrollTop : 0},800, f);
     $("#addPhoto").on(function(){
     $("#addPhoto").animate({
     height: 'toggle'
     });
     });

     });*/
</script>