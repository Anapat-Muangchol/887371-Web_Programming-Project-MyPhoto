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

    <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">

    <link rel="stylesheet" href="css/main.css" type="text/css">

    <script src="https://code.jquery.com/jquery-2.2.3.min.js"
            integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script>
</head>
<body style='background-color: #A8EBFF;'>
<!--Regis-->
<div id="login_regis">
    <div class="container-fluid" style="margin-top: 4vh">
        <div class="row" id="partial">
            <div class="col-md-3 col-xs-0"></div><!--Makes Sign in panel center-->
            <!--Sign in form-->
            <div class="col-md-6 col-xs-12">

                <?php

                echo "<h1 style=\"text-align: center\">M y &nbsp;P h <img src=\"../img/camera-icon.png\" width=\"40\" height=\"40\"> t o
                    </h1>";
                require("../system/database.php");
                $db = new MyPhoto();

                $email = $_POST["email"];
                $password = $_POST["password"];
                $name = $_POST["name"];
                $pic = $_FILES["pic"];

                if ($db->checkEmailNonDupilcate($email)) {
                    //echo $pic['tmp_name']." : tmp_name";
                    if($pic['tmp_name'] != "") {
                        $arraypic = explode(".", $pic['name']);
                        $filetype = strtolower($arraypic[1]);
                        if ($filetype == "jpg" || $filetype == "jpeg" || $filetype == "png" || $filetype == "gif" || $filetype == "") {
                            $email_namefile = "";
                            for ($i = 0; $i < strlen("$email"); $i++) {
                                //echo $i." : ".substr($email, $i, 1)."<br>";
                                if (substr($email, $i, 1) != ".") $email_namefile .= substr($email, $i, 1);
                            }
                            $newimage = "Profile_" . $name . "_" . $email_namefile . "." . $filetype;
                            copy($pic['tmp_name'], "../uploads/" . $newimage);
                            if ($db->add_userPic($email, $password, $name, $newimage)) {
                                //session_destroy();
                                $db->login($email, $password, false);
                                echo "<div id=\"alert\" style='display: none; text-align: center' class=\"alert alert-success\"><h5>Registation successfully.</h5><h4>Welcome ".$_SESSION['name']."</h4></div>";
                            }
                        } else {
                            echo "<div id=\"alert\" style='display: none; text-align: center' class=\"alert alert-danger\"><i class=\"fa fa-exclamation-triangle\" aria-hidden=\"true\"></i> Enter picture is only types jpg, jpeg, png, gif</div>";
                            $_SESSION["reg"] = "have";
                        }
                    }else{
                        if ($db->add_user($email, $password, $name)) {
                            //session_destroy();
                            $db->login($email, $password, false);
                            echo "<div id=\"alert\" style='display: none; text-align: center' class=\"alert alert-success\"><h5>Registation successfully.</h5><h4>Welcome ".$_SESSION['name']."</h4></div>";
                        }
                    }
                } else {
                    echo "<div id=\"alert\" style='display: none; text-align: center' class=\"alert alert-danger\"><i class=\"fa fa-exclamation-triangle\" aria-hidden=\"true\"></i> Your e-mail is already registered.</div>";
                    $_SESSION["reg"] = "have";
                }
                echo "</body>";
                ?>
            </div>
            <!--/Sign in form-->
            <div class="col-md-3 col-xs-0"></div><!--Makes Sign in panel center-->
        </div>
    </div>
</div>
</body>

<script>
    $("#alert").fadeIn(500);
    setTimeout(function(){
        $("#login_regis").fadeOut(500);
        //$("body").css({"background-color": "#FFFFFF", "transition": "background-color 1s ease"});
        setTimeout(function(){
            location.assign("../");
        }, 500);
    }, 2000);
</script>