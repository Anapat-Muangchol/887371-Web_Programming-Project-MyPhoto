<?php session_start();
require("../system/database.php");
$db = new MyPhoto();
$word = $_GET['word'];
?>

<div class="row">
    <div class="col-md-1 col-xs-0"></div>
    <div class="col-md-10 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="form-group" style="text-align: center;">
                    <h3><i class="fa fa-search" aria-hidden="true"></i>&nbsp;&nbsp;<b>Search</b></h3>
                </div>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <?php
                    $itNotHave = true;

                    $db->search_albums($word);
                    $numRow = $db->getNumRow();
                    if ($numRow != 0){
                        $itNotHave = false;
                        echo "<div id='search-albums' style='text-align: center;'>
                                    <label><h4><i class=\"fa fa-camera\" aria-hidden=\"true\"></i>&nbsp;&nbsp;<b>Albums</b>&nbsp;&nbsp;<span
                            class='badge'>".$numRow."</span></h4></label>";
                        $cnt = 0;
                        while ($row = $db->getResult("object")) {
                            if ($cnt == 0) echo "<div class=\"row\">";
                            echo "<div class=\"col-md-4 col-xs-6\">
                                    <a id='showPhotoInAlbum' href=\"factor/showPhotoInAlbum.php?id=".$row->id."\" class=\"thumbnail\">";
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
                        echo "</div><hr>";
                    }

                    $db->search_photos($word);
                    $numRow = $db->getNumRow();
                    if ($numRow != 0){
                        $itNotHave = false;
                        echo "<div id='search-photos' style='text-align: center;'>
                                    <label><h4><i class=\"fa fa-picture-o\" aria-hidden=\"true\"></i>&nbsp;&nbsp;<b>Photos</b>&nbsp;&nbsp;<span
                            class='badge'>".$numRow."</span></h4></label>";
                        $cnt = 0;
                        while ($row = $db->getResult("object")) {
                            if ($cnt == 0) echo "<div class=\"row\">";
                            echo "<div class=\"col-md-3 col-xs-6\">
                                    <a id='photoData' data-toggle=\"modal\" data-target=\"#myModal\" class=\"thumbnail\" href=\"factor/showPhotoData.php?id=".$row->id."\">";
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
                        echo "</div>";
                    }

                    if($itNotHave){
                        echo "<div style='text-align: center; color: red;'><i class=\"fa fa-search\" aria-hidden=\"true\"></i>&nbsp;&nbsp;<b>No result. \"".$word."\"</b></div>";
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-1 col-xs-0"></div>
</div>

<script>
    $(document).ready(function () {
        $('a#showPhotoInAlbum').click(function (e) {
            e.preventDefault();
            $("#showSearch").animate({
                height: 'toggle'
            });
            $("#showEvent").animate({
                height: 'toggle'
            });
            $("#showPhoto").animate({
                height: 'toggle'
            });
            var urlThis = $(this).attr('href');
            $("#showAlbums").fadeTo(500, 0, function () {
                $("#showAlbums").load(urlThis, function () {
                    $("#showAlbums").fadeTo(500, 1);
                })
            });
        });

        $('a#photoData').click(function (e) {
            e.preventDefault();
            var urlThis = $(this).attr('href');
            $('#myModal').load(urlThis);
        });
    });
</script>