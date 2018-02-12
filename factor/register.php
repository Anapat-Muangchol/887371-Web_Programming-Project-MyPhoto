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

<!--Regis-->
<div id="login_regis">
    <div class="container-fluid" style="margin-top: 0vh">
        <div class="row" id="partial">
            <div class="col-md-3 col-xs-0"></div><!--Makes Sign in panel center-->
            <!--Sign in form-->
            <div class="col-md-6 col-xs-12">

                <h1 style="text-align: center">M y &nbsp;P h <img src="img/camera-icon.png" width="40" height="40"> t o
                </h1>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form id="form-regis" method="post" enctype="multipart/form-data" action="factor/doregis.php">
                            <!--email-->
                            <div class="form-group" style="text-align: center">
                                <label><h3>Register</h3></label>
                                <hr>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label><span id="errEmail"></span>
                                <input type="email" class="form-control" id="email" name="email"
                                       placeholder="Enter email"
                                       required="">
                            </div>
                            <!--/email-->
                            <!--password-->
                            <div class="form-group">
                                <label for="password">Password:</label><span id="errPass"></span>
                                <input type="password" class="form-control" id="password" name="password"
                                       placeholder="Enter password"
                                       required="">
                            </div>
                            <!--/password-->
                            <!--name-->
                            <div id="name" class="form-group">
                                <label for="name">Name:</label><span id="errName"></span>
                                <input type="text" class="form-control" id="name" name="name"
                                       placeholder="Enter name"
                                       required="">
                            </div>
                            <!--/picture-->
                            <div id="pic" class="form-group">
                                <label for="pic">Picture profile: &nbsp;&nbsp;&nbsp;</label><span id="errPic"></span>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="showFile" readonly>
                                    <span class="input-group-btn">
                                        <span class="btn btn-primary btn-file">
                                            <i class="fa fa-folder-open-o" aria-hidden="true"></i>&nbsp;&nbsp;Browse
                                            <input type="file" id="pic" name="pic" required=""
                                           accept="image/x-png, image/gif, image/jpeg, image/jpg">
                                        </span>
                                    </span>
                                </div>
                                <span class="help-block">
                                    <h5 style="font-size:12px;">Only supported image types " jpg, jpeg, png, gif "</h5>
                                </span>
                                <hr>
                            </div>
                            <!--/name-->
                            <!--Log in button-->
                            <div class="form-group">
                                <input type="submit" class="form-control btn btn-warning" id="regis-btn"
                                       value="Register">
                                <div id="loading" style='display: none; margin: auto; text-align: center;'><img src="img/loading.gif" width="30" height="30"></div>
                            </div>
                            <!--/Sign in button-->
                        </form>
                    </div>
                </div>
                <div>
                    <a href="#" style="text-align: right;" id="login"><h4><i class="fa fa-sign-in"
                                                                             aria-hidden="true"></i> login</h4></a>
                </div>
                <?php
                session_start();
                session_destroy();
                ?>

            </div>
            <!--/Sign in form-->
            <div class="col-md-3 col-xs-0"></div><!--Makes Sign in panel center-->
        </div>
    </div>
</div>


<script type="text/javascript">

    $(document).ready(function () {
        $("form").submit(function () {
            $("#regis-btn").fadeOut(50, function () {
                $("#loading").fadeIn(50);
            });
        });
        /*
        $("form").submit(function () {
            $("#loading").fadeIn(100);
        });
        */
        $("#login").click(function () {
            $("body").css({"background-color": "#F8FFBF", "transition": "background-color 1s ease"});
            $("#login_regis").fadeTo(500, 0, function () {
                $("#login_regis").load("factor/login.php", function () {
                    $("#login_regis").fadeTo(500, 1);
                });
            });
        });


        $(document).on('change', '.btn-file :file', function () {
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

    });



</script>