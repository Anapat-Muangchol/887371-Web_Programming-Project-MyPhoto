<?php session_start(); ?>

<nav id="showHeader" class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" id="homeButtonInHeader" href="#">
                <h4 style="text-align: center; margin-top: 0px;">
                    M y &nbsp;P h <img src="img/camera-icon.png" width="20" height="20"> t o
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
                        <i class="fa fa-user" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $_SESSION['name'] ?>&nbsp;&nbsp;<i class="fa fa-caret-down" aria-hidden="true"></i>
                    </a>
                    <ul class="dropdown-menu" style="margin-top: 1px;">
                        <!-- User image -->
                        <li class="user-header"
                            style="background-color: #00A1FF; text-align: center; padding-top: 10px; padding-bottom: 1px; margin-top: -5px;">
                            <div class="imgFrameCircleBorder" style="z-index: 5; height: 90px; width: 90px; margin: auto;">
                                <img src="
                                <?php
                                if (isset($_SESSION['pic'])) echo "uploads/" . $_SESSION['pic'];
                                else echo "img/no-avatars.jpg";
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
