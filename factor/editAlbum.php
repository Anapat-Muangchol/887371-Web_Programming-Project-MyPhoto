<?php session_start();
require("../system/database.php");
$db = new MyPhoto();
$albums_id = $_GET['id'];
$db->get_albums_by_albums_id($albums_id);
$row = $db->getResult("object");
?>
<div class="col-md-12 col-xs-12">
    <form id="form-edit-album">
        <label for="nameAlbum">Name album : </label>
        <input type="text" id="nameAlbum" name="nameAlbum" class="form-control" style="margin-bottom: 10px;" placeholder="Enter name album" value="<?php echo $row->name;?>" required="">

        <label for="description">Description : </label>
        <textarea class="form-control" id="description" name="description" rows="5" style="margin-bottom: 10px;" placeholder="Enter description"><?php echo $row->description;?></textarea>

        <button type="submit" id="btn_edit_in_editAlbum" class="btn btn-warning btn-md form-control">
            <i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;&nbsp;Edit
        </button>
        <hr>
    </form>
</div>

<script>
    $(document).ready(function () {

        $('#form-edit-album').submit(function (e) {
            e.preventDefault();
            var id<?php echo " = ".$albums_id;?>;
            var nameAlbum = $("#nameAlbum").val();
            var description = $("#description").val();

            $.post("system/doEditAlbum.php",
                {
                    id: id,
                    name: nameAlbum,
                    description: description
                },
                function (data) {
                    $('#showAlbums').fadeTo(200, 0, function () {
                        $('#showAlbums').load('factor/showPhotoInAlbum.php?id=<?php echo $albums_id;?>', function () {
                            $('#showAlbums').fadeTo(200, 1);
                        });
                    });

                }
            );

        });


    });

</script>