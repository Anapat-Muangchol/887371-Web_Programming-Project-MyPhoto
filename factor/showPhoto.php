<?php session_start();
require("../system/database.php");
$db = new MyPhoto();
$db->get_photos_by_idUser();
?>

<div class="row">
    <div class="col-md-1 col-xs-0"></div>
    <div class="col-md-10 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="form-group" style="text-align: center;">
                    <h3><i class="fa fa-picture-o" aria-hidden="true"></i>&nbsp;&nbsp;<b>Photos</b>&nbsp;&nbsp;<span
                            class='badge'><?php echo $db->getNumRow(); ?></span></h3>
                </div>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <?php

                    $numRow = $db->getNumRow();
                    if ($numRow == 0) echo "<div style='width: 100%; text-align: center;'><h4>No photo</h4></div>";

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
                    ?>
                </div>
            </div>
            <div class="panel-footer clearfix">
                <button class="btn btn-info btn-md pull-right" id="uploadButtonInShowPhoto"><i
                        class="fa fa-cloud-upload" aria-hidden="true"></i>&nbsp;&nbsp;Uploads
                </button>
                <input type="hidden" name="dataPhotos001">
            </div>
        </div>
    </div>
    <div class="col-md-1 col-xs-0"></div>
</div>


<script>
    $('a#photoData').click(function (e) {
        e.preventDefault();
        var urlThis = $(this).attr('href');
        $('#myModal').load(urlThis);
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