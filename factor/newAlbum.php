<?php session_start();
require("../system/database.php");
$db = new MyPhoto();
?>

<div class="row">
    <div class="col-md-1 col-xs-0"></div>
    <div class="col-md-10 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">

                <div class="form-group" style="text-align: center;">
                    <button id="btn_back_in_newAlbum" class="btn btn-default btn-md pull-left"
                            style="background-color: white;"><i
                            class="fa fa-chevron-circle-left" aria-hidden="true"></i>&nbsp;&nbsp;Back
                    </button>
                    <h3><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;&nbsp;<b>New album</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
            </div>
            <form id="form-newAlbum" method="post" enctype="multipart/form-data" action="system/doNewAlbum.php">
                <div class="panel-body">
                    <div class="form-group">
                        <label for="newAlbum_name">Name album &nbsp;:&nbsp;&nbsp;</label>
                        <input type="text" id="newAlbum_name" name="name" class="form-control" placeholder="Enter name album" required="">
                        <br>
                        <label for="newAlbum_description">Description &nbsp;:&nbsp;&nbsp;</label>
                        <textarea id="newAlbum_description" name="description" class="form-control" rows="5" placeholder="Enter description"></textarea>
                        <hr>
                        <label for="pic">Upload photos &nbsp;:&nbsp;&nbsp;</label><span id="errPic"></span>
                        <div class="input-group">
                            <input type="text" id="newAlbum_showFile" class="form-control" readonly>
                                <span class="input-group-btn">
                                    <span class="btn btn-primary btn-file" id="newAlbum_file">
                                        <i class="fa fa-folder-open-o" aria-hidden="true"></i>&nbsp;&nbsp;Browse
                                        <input type="file" id="newAlbum_pic" name="newAlbum_pic[]"
                                               accept="image/x-png, image/gif, image/jpeg, image/jpg" multiple/>
                                    </span>
                                </span>
                        </div>
                        <span class="help-block">
                            <h5 style="font-size:12px;">Only supported image types " jpg, jpeg, png, gif "</h5>
                        </span>
                    </div>
                </div>
                <div class="panel-footer clearfix">
                    <button id="btn_newAlbum_in_showAlbum" style="width: 100%;" class="btn btn-success btn-md"><i
                            class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;&nbsp;New
                        Album
                    </button>
                    <div id="loading_in_newAlbum" style='display: none; width: 100%; text-align: center;'><img
                            src="img/loading.gif" width="30" height="30"><h6>Uploading...</h6></div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-1 col-xs-0"></div>
</div>

<script>
    $(document).ready(function () {

        $('#btn_back_in_newAlbum').click(function () {
            $("#showAlbums").fadeTo(500, 0, function () {
                $("#showAlbums").load('factor/showAlbums.php', function () {
                    $("#showAlbums").fadeTo(500, 1);
                })
            });
        });

        $(document).on('submit', '#form-newAlbum', function () {
            $("#btn_newAlbum_in_showAlbum").fadeOut(50, function () {
                $("#loading_in_newAlbum").fadeIn(50);
            });
            $("#showSearch").fadeOut(500);
            $("#addPhoto").fadeOut(500);
            $("#showPhoto").fadeOut(500);
            $("#showEvent").fadeOut(500);
            $("#btn_back_in_newAlbum").prop('disabled', true);
            $("#homeButtonInHeader").prop('disabled', true);
            $("#homeButtonInHeader").removeAttr("href");
            $('#buttonSearchInHeader').prop('disabled', true);
            $('#buttonSearchInHeader').removeAttr("href");
            $('#buttonUploadInHeader').prop('disabled', true);
            $('#buttonUploadInHeader').removeAttr("href");
            $('#buttonProfileDropDownInHeader').prop('disabled', true);
            $('#buttonProfileDropDownInHeader').removeAttr("href");
            //$('#pic').prop('disabled', true);
        });

    });

    $(document).on('change', '#newAlbum_file.btn-file :file', function () {
        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        //alert(numFiles+" : "+label);
        var input = $('#newAlbum_showFile'),
            log = numFiles > 1 ? numFiles + ' files selected' : label;
        //alert("log : "+log);
        if (input.length) {
            input.val(log);
        } else {
            if (log) alert(log);
        }
    });
</script>


