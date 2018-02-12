<html>
<head>
    <meta charset="UTF-8">
    <title>My Photo</title>

    <link rel="icon" href="img/camera-icon.png">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://code.jquery.com/jquery-2.2.3.min.js"
            integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script>
    
    <!-- Latest compiled JavaScript -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">

    <link rel="stylesheet" href="css/main.css" type="text/css">

    <link rel="stylesheet" href="css/adminlte.css" type="text/css">

    <script type="text/javascript" src="css/bootstrap-filestyle-1.2.1/src/bootstrap-filestyle.min.js"> </script>
</head>


<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['name']) && isset($_SESSION['permission'])) { ?>

    <body style='background-color: #E8E8E8;'>
    <nav id="showHeader"></nav>
    <div class="container">
        <div id="myModal" class="modal fade" role="dialog"></div>
        <div id="showSearch" style='display: none;'></div>
        <div id="showEvent" style='display: none;'></div>
        <div id="addPhoto"></div>
        <div id="showAlbums"></div>
        <div id="showPhoto"></div>

    </div>
    </body>

    <script>
        /*
        window.onbeforeunload = function() {
            return "Uploading your photos!!";
        };
        */
        function home() {
            $("#showSearch").load("factor/search.php");
            $("#addPhoto").load("factor/addPhoto.php");
            $("#showAlbums").load("factor/showAlbums.php", function () {
                $("#showAlbums").animate({
                    height: 'show'
                });
            });
            $("#showPhoto").load("factor/showPhoto.php", function () {
                $("#showPhoto").animate({
                    height: 'show'
                });
            });
            $("#showPhoto, #showSearch, #addPhoto, #showEvent").animate({
                height: 'hide'
            });
            $("#showEvent").html("");
        }


        $(document).ready(function () {

            //========== Load All ==========
            $.get("factor/header.php", function(data) {
                $("#showHeader").replaceWith(data);
            });
            //$("#showHeader").load("factor/header.php");
            $("#showSearch").load("factor/search.php");
            $("#addPhoto").load("factor/addPhoto.php");
            $("#showAlbums").load("factor/showAlbums.php");
            $("#showPhoto").load("factor/showPhoto.php");
            $("#showSearch").fadeOut(0);
            $("#addPhoto").fadeOut(0);
            $("#showEvent").fadeOut(0);
            //==============================


            //========== Home ==========
            $(document).on("click", "#homeButtonInHeader", function(){  home();  });
            //==============================


            //========== Search ==========
            $(document).on("click", "#buttonSearchInHeader", function(){
                $("#showSearch").animate({
                    height: 'toggle'
                });
                $("#showEvent").animate({
                    height: 'toggle'
                });
            });
            //==============================


            //========== Uploads ==========
            $(document).on("click", "#buttonUploadInHeader", function(){
                $("#addPhoto").animate({
                    height: 'toggle'
                });
            });
            $("#showPhoto").on("click", "#uploadButtonInShowPhoto", function () {
                $('html, body').animate({scrollTop: 0}, 300, function () {
                    $("#addPhoto").animate({
                        height: 'show'
                    });
                });
            });
            //==============================


            //========== Logout ==========
            $(document).on("click", "#logoutButton", function(){
                var r = confirm("Are you sure to logout?");
                if (r == true) {
                    $("body").fadeTo(1000, 0, function () {
                        logout();
                        $("body").load("factor/logout.php", function () {
                            $("body").fadeTo(500, 1, function () {
                                setTimeout(function(){
                                    $("body").css({"background-color": "#FFFFFF", "transition": "background-color 1s ease"});
                                    $("body").fadeTo(500, 0);
                                    setTimeout(function(){
                                        location.reload();
                                    }, 500);
                                }, 1000);
                            });
                        });
                    });
                }
            });
            function logout() {
                $.post("system/login-logout.php",
                    { mode: "logout" }
                );
            }
            //===============================



        });

    </script>
<?php
}else{

if (isset($_SESSION["reg"])){
?>
    <body style='background-color: #A8EBFF;'></body>
    <script type="text/javascript">
        $(document).ready(function () {
            //$("body").css({"background-color": "#A8EBFF", "transition": "background-color 1s ease"});
            $("body").fadeTo(0, 0, function () {
                $("body").load("factor/register.php");
                $("body").fadeTo(500, 1);
            });
        });
    </script>
<?php }else{ ?>
    <body style='background-color: #FFFFFF;'></body>
    <script type="text/javascript">
        $(document).ready(function () {
            $("body").fadeTo(0, 0, function () {
                $("body").load("factor/login.php", function () {
                    $("body").css({"background-color": "#F8FFBF", "transition": "background-color .5s ease"});
                    $("body").fadeTo(500, 1);
                });
            });
        });
    </script>
    <?php
}//echo file_get_contents("factor/login.php");


}
?>

</html>






