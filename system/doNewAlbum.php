<head>
    <meta charset="UTF-8">
    <title>My Photo</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="stylesheet" href="../css/font-awesome/css/font-awesome.min.css">

    <link rel="stylesheet" href="../css/main.css" type="text/css">

    <script src="https://code.jquery.com/jquery-2.2.3.min.js"
            integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script>
</head>
<body>
<?php session_start(); ?>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" id="homeButtonInHeader" href="#">
                <h4 style="text-align: center; margin-top: 0px;">
                    M y &nbsp;P h <img src="../img/camera-icon.png" width="20" height="20"> t o
                </h4>
            </a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-left">
                <li style="text-align: center;"><a href="#" id="buttonSearchInHeader"><i class="fa fa-search"
                                                                                         aria-hidden="true"></i> &nbsp;Search</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li style="text-align: center;"><a href="#" id="buttonUploadInHeader"><i class="fa fa-cloud-upload"
                                                                                         aria-hidden="true"></i>&nbsp;Uploads</a>
                </li>
                <li class="dropdown" style="right: 0; text-align: center;">
                    <a class="dropdown-toggle" data-toggle="dropdown" id="buttonProfileDropDownInHeader" href="#">
                        <i class="fa fa-user" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $_SESSION['name'] ?>&nbsp;&nbsp;<i
                            class="fa fa-caret-down" aria-hidden="true"></i>
                    </a>
                    <ul class="dropdown-menu" style="margin-top: 1px;">
                        <!-- User image -->
                        <li class="user-header"
                            style="background-color: #00A1FF; text-align: center; padding-top: 10px; padding-bottom: 1px; margin-top: -5px;">
                            <div class="imgFrameCircleBorder"
                                 style="z-index: 5; height: 90px; width: 90px; margin: auto;">
                                <img src="
                                <?php
                                if (isset($_SESSION['pic'])) echo "../uploads/" . $_SESSION['pic'];
                                else echo "../img/no-avatars.jpg";
                                ?>" class="imgInFrameCircle" style="height: 90px;">
                            </div>
                            <p>
                            <h5><b><?php echo $_SESSION['name'] ?></b></h5>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div style="text-align: center; margin-top: 5px;">
                                <a href="#" id="logoutButton" class="btn btn-danger btn-flat"><i class="fa fa-sign-out"
                                                                                                 aria-hidden="true"></i>&nbsp;&nbsp;Log
                                    out</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>


<!--newAlbum-->
<div id="allNewAlbum">
    <div class="container-fluid" style="margin-top: 4vh">
        <div class="row" id="partial">
            <div class="col-md-3 col-xs-0"></div><!--Makes Sign in panel center-->
            <!--Sign in form-->
            <div class="col-md-6 col-xs-12">

                <?php
                require("database.php");
                $db = new MyPhoto();

                $db->add_albums($_POST['name'], $_POST['description']);
                $albums_id = $db->getResult("value");
                echo "<div id=\"alertNewAlbum\" style='display: none; text-align: center' class=\"alert alert-success\"><h5><i class=\"fa fa-check-circle\" aria-hidden=\"true\"></i>&nbsp;&nbsp;New " . $_POST['name'] . " album successfully.</h5></div>";

                $pic = $_FILES['newAlbum_pic'];
                $fileCount = count($pic['name']);
                $cntUploadSuc = 0;
                $cntUploadFail = 0;
                
                $db->get_numOfPhoto_in_albums($albums_id);
                $num = $db->getResult("object")->numOfPhoto;
                $nameReal = "";
                if($pic['name'][0] != ""){
                    for ($i = 0; $i < $fileCount; $i++) {
                        $arraypic = explode(".", $pic['name'][$i]);
                        $filetype = strtolower($arraypic[1]);
                        $nameShow = $arraypic[0];
                        $size = $pic['size'][$i];
                        
                        if ($filetype == "jpg" || $filetype == "jpeg" || $filetype == "png" || $filetype == "gif") {
                            $nameReal = $_SESSION['id'] . "_" . $_SESSION['name'] . "_" . $nameShow . "." . $filetype;//รวมชื่อไฟล์กับนามสกุลเข้าด้วยกัน
                            copy($pic['tmp_name'][$i], "../uploads/" . $nameReal); //โฟลเดอร์สำหรับเก็บรูป/ไฟล์รูป
                            $db->add_photos_in_album($nameShow, $nameReal, $filetype, $size, $albums_id);
                            $cntUploadSuc++;
                        } else {
                            $cntUploadFail++;
                        }
                    }
                }

                if ($cntUploadSuc > 0 && $cntUploadFail == 0) {
                    $num += $cntUploadSuc;
                    $db->update_numOfPhoto_in_album($albums_id, $num);
                    $db->update_coverPhoto_in_album($albums_id, $nameReal);
                    echo "<div id=\"alertPhoto\" style='display: none; text-align: center' class=\"alert alert-success\"><h5><i class=\"fa fa-check-circle\" aria-hidden=\"true\"></i>&nbsp;&nbsp;" . $cntUploadSuc . " photos uploads successfully.</h5></div>";
                } else if ($cntUploadSuc > 0 && $cntUploadFail > 0) {
                    $num += $cntUploadSuc;
                    $db->update_numOfPhoto_in_album($albums_id, $num);
                    $db->update_coverPhoto_in_album($albums_id, $nameReal);
                    echo "<div id=\"alertPhoto\" style='display: none; text-align: center' class=\"alert alert-success\"><h5><i class=\"fa fa-check-circle\" aria-hidden=\"true\"></i>&nbsp;&nbsp;" . $cntUploadSuc . " photos uploads successfully. </h5><h5 style='color: red;'><i class=\"fa fa-exclamation-triangle\" aria-hidden=\"true\"></i>&nbsp;&nbsp;" . $cntUploadFail . " photos upload unsuccessfully. Because photos type inconsistent.</h5></div>";
                } else if ($cntUploadSuc == 0 && $cntUploadFail > 0) {
                    echo "<div id=\"alertPhoto\" style='display: none; text-align: center' class=\"alert alert-danger\"><h5 style='color: red;'><i class=\"fa fa-exclamation-triangle\" aria-hidden=\"true\"></i>&nbsp;&nbsp;".$cntUploadFail."upload unsuccessfully. Because photos type inconsistent.</h5></div>";
                } else{}
                

                ?>
            </div>
            <!--/Sign in form-->
            <div class="col-md-3 col-xs-0"></div><!--Makes Sign in panel center-->
        </div>
    </div>
</div>
</body>

<script>
    $("#alertNewAlbum").fadeIn(500);
    <?php
    if($cntUploadSuc != 0 || $cntUploadFail != 0)echo "$(\"#alertPhoto\").fadeIn(500);";
    ?>
    setTimeout(function () {
        $("#allNewAlbum").fadeOut(500);
        //$("body").css({"background-color": "#FFFFFF", "transition": "background-color 1s ease"});
        setTimeout(function () {
            location.assign("../");
        }, 500);
    }, 3000);
</script>