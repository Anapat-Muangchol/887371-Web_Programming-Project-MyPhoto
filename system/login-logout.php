<?php
require("database.php");

$db = new MyPhoto();
$mode = $_POST['mode'];
if ($mode == "login") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $stayLoggedIn = $_POST['remember'];

    if (!empty($email) AND !empty($password)){
        if ($db->login($email, $password, $stayLoggedIn)) echo "{\"status\":\"Login successfully.\"}";
        else echo "{\"status\":\"Please check your e-mail and password.\"}";
    } else {
        $err = "{";
        if (empty($email) AND empty($password)) {
            $err .= "\"errEmail\":\"Please fill your e-mail\"";
            $err .= ",";
            $err .= "\"errPass\":\" and password.\"";
        }
        else if (empty($email)) $err .= "\"errEmail\":\"Please fill your e-mail.\"";
        else if (empty($password)) $err .= "\"errPass\":\"Please fill your password.\"";
        $err .= "}";
        echo $err;
    }
} else if ($mode == "logout") {
    $db->logout();
}
