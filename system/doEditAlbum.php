<?php session_start(); ?>

<?php
require("database.php");
$db = new MyPhoto();
$id = $_POST['id'];
$name = $_POST['name'];
$description = $_POST['description'];

$db->update_name_and_description_in_album($id, $name, $description);
?>