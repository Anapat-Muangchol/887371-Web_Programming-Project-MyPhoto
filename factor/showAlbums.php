<?php session_start();
require("../system/database.php");
$db = new MyPhoto();
$db->get_albums();
?>

<div class="row">
    <div class="col-md-1 col-xs-0"></div>
    <div class="col-md-10 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="form-group" style="text-align: center;">
                    <h3><i class="fa fa-camera" aria-hidden="true"></i>&nbsp;&nbsp;<b>Albums</b>&nbsp;&nbsp;<span
                            class='badge'><?php echo $db->getNumRow(); ?></span></h3>
                </div>
            </div>
            <div class="panel-body">
                <div class="form-group">

                    <?php
                    $numRow = $db->getNumRow();
                    if ($numRow == 0) echo "<div style='width: 100%; text-align: center;'><h4>No albums</h4></div>";

                    $cnt = 0;
                    while ($row = $db->getResult("object")) {
                        if ($cnt == 0) echo "<div class=\"row\">";
                        echo "<div class=\"col-md-4 col-xs-6\">";
                        if($row->id == 18)echo "<a href=\"57160033-SourceCode.rar\" class=\"thumbnail\">";
                        else echo "<a id='showPhotoInAlbum' href=\"factor/showPhotoInAlbum.php?id=".$row->id."\" class=\"thumbnail\">";
                        if ($row->coverPhoto != "") echo "<img src=\"uploads/" . $row->coverPhoto . "\" style=\"max-width:100%;max-height:100%;\">";
                        else echo "<img src=\"img/no-pic.png\" style=\"max-width:100%;max-height:100%;\">";
                        echo "      <h4 style=\"text-align: center\">" . $row->name . "</h4>
                                    </a>
                                </div>";

                        $numRow--;
                        $cnt++;
                        if ($cnt >= 3 || $numRow == 0) {
                            echo "</div>";
                            $cnt = 0;
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="panel-footer clearfix">
                <button id="btn_newAlbum_in_showAlbum" class="btn btn-info btn-md pull-right"><i
                        class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;&nbsp;New
                    Album
                </button>
            </div>
        </div>
    </div>
    <div class="col-md-1 col-xs-0"></div>
</div>

<script>
    $(document).ready(function () {
        $('a#showPhotoInAlbum').click(function (e) {
            e.preventDefault();
            var urlThis = $(this).attr('href');
            $("#showAlbums").fadeTo(500, 0, function () {
                $("#showAlbums").load(urlThis, function () {
                    $("#showAlbums").fadeTo(500, 1);
                })
            });
        });

        $('#btn_newAlbum_in_showAlbum').click(function () {
            $("#showAlbums").fadeTo(500, 0, function () {
                $("#showAlbums").load('factor/newAlbum.php', function () {
                    $("#showAlbums").fadeTo(500, 1);
                })
            });
        });


    });
</script>


