<?php
session_start();
require("../system/database.php");
$db = new MyPhoto();
$db->get_photos_by_idPhoto($_GET['id']);
$row = $db->getResult("object");
?>


<div id="forPC" class="modal-dialog" style="width: 70%; display: none;">
    <div class="container-fluid" style="width: 100%;">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div id="displayPhoto" class="modal-content" style="width: 100%;">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-picture-o" aria-hidden="true"></i>&nbsp;&nbsp;<b><?php echo $row->nameShow;?></b></h4>
                    </div>
                    <div class="modal-body" style="text-align: center;">
                        <?php
                        echo "<img src=\"uploads/" . $row->nameReal . "\" style=\"width: auto; max-width: 800px; height: auto; max-height: 450px;\">";
                        ?>
                    </div>
                    <div class="modal-footer">
                        <button id="delete" class='btn btn-danger pull-left'><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;&nbsp;Delete
                        </button>
                        <a href="uploads/<?php echo $row->nameReal;?>" download class='btn btn-info pull-right'><i class="fa fa-download" aria-hidden="true"></i>&nbsp;&nbsp;Download
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="forMobile" class="modal-dialog" style="width: 90%; display: none;">
    <div class="container-fluid" style="width: 105%;">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div id="displayPhotoForModile" class="modal-content" style="width: 100%;">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-picture-o" aria-hidden="true"></i>&nbsp;&nbsp;<b><?php echo $row->nameShow;?></b></h4>
                    </div>
                    <div class="modal-body" style="text-align: center;">
                        <?php
                        echo "<img src=\"uploads/" . $row->nameReal . "\" style=\"width: auto; max-width: 240px; height: auto; max-height: 450px;\">";
                        ?>
                    </div>
                    <div class="modal-footer">
                        <button id="deleteForMobile" class='btn btn-danger pull-left'><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;&nbsp;Delete
                        </button>
                        <a href="uploads/<?php echo $row->nameReal;?>" download class='btn btn-info pull-right'><i class="fa fa-download" aria-hidden="true"></i>&nbsp;&nbsp;Download
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var sizeMobile = false, sizePC = false;
    if ($(window).width() < 767) {
        sizeMobile = true;
        $('#forMobile').fadeIn(0);
    } else {
        sizePC = true;
        $('#forPC').fadeIn(0);
    }
    $(window).resize(function() {
        if ($(window).width() < 767) {
            if(sizePC){
                sizePC = false;
                sizeMobile = true;
                $('#forPC').fadeOut(1);
                $('#forMobile').fadeIn(1);
            }
        } else {
            if(sizeMobile){
                sizeMobile = false;
                sizePC = true;
                $('#forMobile').fadeOut(1);
                $('#forPC').fadeIn(1);
            }
        }
    });

    $('#delete, #deleteForMobile').click(function () {
        var r = confirm("Are you sure to delete this photo?");
        if (r == true) {
            var urlDel = "system/delete.php?mode=photo&id=<?php echo $_GET['id'];?>&albums_id=<?php echo $_GET['albums_id'];?>";
            $('#displayPhoto, #displayPhotoForModile').load(urlDel);
        }
    })
</script>