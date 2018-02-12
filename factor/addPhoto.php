<div class="row">
    <div class="col-md-3 col-xs-1"></div>
    <div class="col-md-6 col-xs-10">
        <div class="panel panel-default">
            <div class="panel-body">
                <form id="form-addPhoto" method="post" enctype="multipart/form-data" action="system/doaddphoto.php">
                    <label for="pic">Upload photos &nbsp;:&nbsp;&nbsp;</label><span id="errPic"></span>
                    <div class="input-group">
                        <input type="text" id="showFile" class="form-control" readonly>
                                <span class="input-group-btn">
                                    <span class="btn btn-primary btn-file" id="addPhoto_file">
                                        <i class="fa fa-folder-open-o" aria-hidden="true"></i>&nbsp;&nbsp;Browse
                                        <input type="file" id="pic" name="pic[]" required=""
                                               accept="image/x-png, image/gif, image/jpeg, image/jpg" multiple/>
                                    </span>
                                </span>
                    </div>
                        <span class="help-block">
                            <h5 style="font-size:12px;">Only supported image types " jpg, jpeg, png, gif "</h5>
                        </span>
                    <hr>
                    <label for="pic">Select your album :</label>
                    <select name="album" class="form-control">
                        <option value="none">None</option>
                        <?php
                        $albums_id = $_GET['albums_id'];
                        require("../system/database.php");
                        $db = new MyPhoto();
                        $db->get_albums();

                        while ($row = $db->getResult("object")) {
                            if($albums_id == $row->id)echo "<option value=\"" . $row->id . "\" selected>" . $row->name . "</option>";
                            else echo "<option value=\"" . $row->id . "\">" . $row->name . "</option>";
                        }
                        ?>
                    </select>
                    <hr>
                    <button type="submit" class="btn btn-success" id="buttonUploadInAddPhoto"
                            style="margin-top: -5px; width: 100%;">
                        <i class="fa fa-cloud-upload" aria-hidden="true"></i>&nbsp;&nbsp;Uploads
                    </button>
                    <div id="loading" style='display: none; width: 100%; text-align: center;'><img
                            src="img/loading.gif" width="30" height="30"><h6>Uploading...</h6></div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-xs-1"></div>
</div>

<script>
    $(document).on('submit', '#form-addPhoto', function () {
        $("#buttonUploadInAddPhoto").fadeOut(50, function () {
            $("#loading").fadeIn(50);
        });
        $("#showSearch").fadeOut(500);
        $("#showAlbums").fadeOut(500);
        $("#showPhoto").fadeOut(500);
        $("#showEvent").fadeOut(500);
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


    $(document).on('change', '#addPhoto_file.btn-file :file', function () {
        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        //alert(numFiles+" : "+label);
        var input = $('#showFile'),
            log = numFiles > 1 ? numFiles + ' files selected' : label;
        //alert("log : "+log);
        if (input.length) {
            input.val(log);
        } else {
            if (log) alert(log);
        }
    });
</script>
