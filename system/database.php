<?php
session_start();
class MyPhoto
{
    /*
     * Connection variables.
     */
    private $db_host = "localhost";
    private $db_user = "it57160033";
    private $db_password = "fomfomza";
    private $db_database_select = "it57160033";
    private $link = null;
    /*
     * User information
     */
    private $username = null;
    /*
     * Database query variables.
     */
    private $sql = null;
    private $result = null;
    function __construct()
    {
        //$this->username = $_SESSION['username'];
        $this->Open();
    }
    /*
     * Connect or disconnect the database.
     */
    public function Open()
    {
        if (isset($this->link)) {
            echo "Warning : You already connected to MySql.";
        } else {
            $this->link = mysqli_connect($this->db_host, $this->db_user, $this->db_password, $this->db_database_select);
            if (mysqli_error($this->link)) {
                die("Connection failed: " . mysqli_error($this->link));
            }
            return true;
        }
        return false;
    }
    public function Close()
    {
        mysqli_close($this->link);
    }
    /*
     * Run SQL command to the database.
     */
    public function getResult($mode)
    {
        if($mode == "object")
        {
            return mysqli_fetch_object($this->result);    
        }
        elseif($mode == "assoc")
        {
            return mysqli_fetch_assoc($this->result);
        }
        elseif ($mode == "array")
        {
            return mysqli_fetch_array($this->result);
        }
        elseif ($mode == "value")
        {
            return $this->result;
        }
        return false;
    }
    
    public function getNumRow()
    {
        return mysqli_num_rows($this->result);
    }
    private function executeQuery()
    {
        mysqli_query($this->link,"SET NAMES UTF8");
        if (mysqli_errno($this->link)) {
            echo "MySQL error " . mysqli_errno($this->link) . ": "
                . mysqli_errno($this->link) . "\n<br>When executing <br>\n$this->sql\n<br>";
            return false;
        }
        $this->result = mysqli_query($this->link, $this->sql);
        return true;
    }

    /*
     * Common query.
     */
    public function select_all_from($table)
    {
        $table = mysqli_real_escape_string($this->link, $table);
        $this->sql = "SELECT * FROM `" . $table . "`";
        $this->executeQuery();
    }
    public function select_where_one($field, $predict, $table)
    {
        $predict = mysqli_real_escape_string($this->link, $predict);
        $field = mysqli_real_escape_string($this->link, $field);
        $table = mysqli_real_escape_string($this->link, $table);
        $predict_tmp = null;
        if (!is_numeric($predict)) {
            $predict_tmp = "'" . $predict . "'";
        } else {
            $predict_tmp = $predict;
        }
        $this->sql = "SELECT * FROM `" . $table . "` WHERE `" . $field . "` = " . $predict_tmp;
        $this->executeQuery();
    }
    public function get_albums()
    {
        $this->sql = "SELECT * FROM `albums` WHERE `members_id`=" . $_SESSION['id'];
        //echo $this->sql;
        $this->executeQuery();
    }
    public function get_albums_by_albums_id($id)
    {
        $id = mysqli_real_escape_string($this->link, $id);
        $this->sql = "SELECT * FROM `albums` WHERE `id`=" . $id ." AND `members_id`=" . $_SESSION['id'];
        //echo $this->sql;
        $this->executeQuery();
    }
    public function get_albums_id($name, $description){
        $name = mysqli_real_escape_string($this->link, $name);
        $description = mysqli_real_escape_string($this->link, $description);
        $this->sql = "SELECT id FROM `albums` WHERE `members_id`=" . $_SESSION['id']." AND `name`=".$name." AND `description`=".$description;
        //echo $this->sql;
        $this->executeQuery();
    }
    public function get_numOfPhoto_in_albums($albums_id){
        $albums_id = mysqli_real_escape_string($this->link, $albums_id);
        $this->sql = "SELECT `numOfPhoto` FROM `albums` WHERE `id`=" . $albums_id;
        //echo $this->sql;
        $this->executeQuery();
    }
    public function get_cover_photo_albums($albums_id){
        $albums_id = mysqli_real_escape_string($this->link, $albums_id);
        $this->sql = "SELECT `coverPhoto` FROM `albums` WHERE `albums_id`=" . $albums_id;
        //echo $this->sql;
        $this->executeQuery();
    }
    public function get_photos_by_albums($albums_id)
    {
        $albums_id = mysqli_real_escape_string($this->link, $albums_id);
        $this->sql = "SELECT * FROM `photos` WHERE `albums_id`=" . $albums_id;
        //echo $this->sql;
        $this->executeQuery();
    }
    public function get_photos_by_idUser()
    {
        $this->sql = "SELECT * FROM `photos` WHERE `albums_id` IS NULL AND `members_id`=" . $_SESSION['id'];
        //echo $this->sql;
        $this->executeQuery();
    }
    public function get_photos_by_idPhoto($id)
    {
        $id = mysqli_real_escape_string($this->link, $id);
        $this->sql = "SELECT * FROM `photos` WHERE `id`=" . $id;
        //echo $this->sql;
        $this->executeQuery();
    }

    /*
     * Add
     */
    public function add_albums($name, $description){
        $name = mysqli_real_escape_string($this->link, $name);
        $description = mysqli_real_escape_string($this->link, $description);
        $this->sql = "INSERT INTO `albums` (`name`, `description`,  `numOfPhoto`,  `dateCreate`, `members_id`) VALUES ('NEW" . $name . "NEW', '" . $description . "', 0, '" . date("Y/m/d")." ".date("H:i:sa") . "', " . $_SESSION['id'] . ");";
        //echo $this->sql."<br>";
        $this->executeQuery();
        $this->sql = "SELECT id FROM `albums` WHERE `members_id`=" . $_SESSION['id']." AND `name`='NEW".$name."NEW' AND `description`='".$description."'";
        //echo $this->sql."<br>";
        $this->executeQuery();
        $albums_id = $this->getResult("object")->id;
        //echo $albums_id."<br>";
        $this->sql = "UPDATE `albums` SET `name` = '" . $name . "' WHERE `id` = " . $albums_id . ";";
        //echo $this->sql."<br>";
        $this->executeQuery();
        $this->result = $albums_id;
    }
    public function add_photos($nameShow, $nameReal, $type, $size){
        $nameShow = mysqli_real_escape_string($this->link, $nameShow);
        $nameReal = mysqli_real_escape_string($this->link, $nameReal);
        $type = mysqli_real_escape_string($this->link, $type);
        $size = mysqli_real_escape_string($this->link, $size);
        $this->sql = "INSERT INTO `photos` (`nameShow`, `nameReal`,  `type`, `size`, `dateUpload`, `members_id`) VALUES ('" . $nameShow . "', '" . $nameReal . "', '" . $type . "', '" . $size . "', '" . date("Y/m/d")." ".date("H:i:sa") . "', " . $_SESSION['id'] . ");";
        $this->executeQuery();
    }
    public function add_photos_in_album($nameShow, $nameReal, $type, $size, $albums_id){
        $nameShow = mysqli_real_escape_string($this->link, $nameShow);
        $nameReal = mysqli_real_escape_string($this->link, $nameReal);
        $type = mysqli_real_escape_string($this->link, $type);
        $size = mysqli_real_escape_string($this->link, $size);
        $albums_id = mysqli_real_escape_string($this->link, $albums_id);
        $this->sql = "INSERT INTO `photos` (`nameShow`, `nameReal`,  `type`, `size`, `dateUpload`, `albums_id`, `members_id`) VALUES ('" . $nameShow . "', '" . $nameReal . "', '" . $type . "', '" . $size . "', '" . date("Y/m/d")." ".date("H:i:sa") . "', " . $albums_id . ", " . $_SESSION['id'] . ");";
        $this->executeQuery();
    }
    public function update_numOfPhoto_in_album($albums_id, $num){
        $albums_id = mysqli_real_escape_string($this->link, $albums_id);
        $num = mysqli_real_escape_string($this->link, $num);
        $this->sql = "UPDATE `albums` SET `numOfPhoto` = " . $num . " WHERE `id` = " . $albums_id . ";";
        $this->executeQuery();
    }
    public function update_coverPhoto_in_album($albums_id, $namePhoto){
        $albums_id = mysqli_real_escape_string($this->link, $albums_id);
        $namePhoto = mysqli_real_escape_string($this->link, $namePhoto);
        $this->sql = "UPDATE `albums` SET `coverPhoto` = '" . $namePhoto . "' WHERE `id` = " . $albums_id . ";";
        $this->executeQuery();
    }
    public function update_name_and_description_in_album($id, $name, $description){
        $id = mysqli_real_escape_string($this->link, $id);
        $name = mysqli_real_escape_string($this->link, $name);
        $description = mysqli_real_escape_string($this->link, $description);
        $this->sql = "UPDATE `albums` SET `name` = '" . $name . "', `description` = '" . $description . "', `dateEdit` = '" . date("Y/m/d")." ".date("H:i:sa") . "' WHERE `id` = " . $id . ";";
        $this->executeQuery();
    }


    /*
     * Delete.
     */
    public function delete_photos_by_idPhoto($id)
    {
        $id = mysqli_real_escape_string($this->link, $id);
        $this->sql = "DELETE FROM `photos` WHERE `id`=" . $id;
        //echo $this->sql;
        $this->executeQuery();
    }
    public function delete_album_by_albums_id($id)
    {
        $id = mysqli_real_escape_string($this->link, $id);

        $this->sql = "Update `photos` set `albums_id` = NULL WHERE `albums_id` = " . $id . ";";
        //echo $this->sql;
        $this->executeQuery();

        $this->sql = "DELETE FROM `albums` WHERE `id`=" . $id;
        //echo $this->sql;
        $this->executeQuery();
    }
    public function delete_album_and_photos_by_albums_id($id)
    {
        $id = mysqli_real_escape_string($this->link, $id);

        $this->sql = "DELETE FROM `photos` WHERE `albums_id`=" . $id;
        //echo $this->sql;
        $this->executeQuery();

        $this->sql = "DELETE FROM `albums` WHERE `id`=" . $id;
        //echo $this->sql;
        $this->executeQuery();
    }

    /*
     * Search.
     */
    public function search_albums($word)
    {
        $word = mysqli_real_escape_string($this->link, $word);
        $this->sql = "SELECT * FROM `albums` WHERE (`name` LIKE '%".$word."%' OR `description` LIKE '%".$word."%') AND members_id=".$_SESSION['id'].";";
        //echo $this->sql;
        $this->executeQuery();
    }
    public function search_photos($word)
    {
        $word = mysqli_real_escape_string($this->link, $word);
        $this->sql = "SELECT * FROM `photos` WHERE (`nameShow` LIKE '%".$word."%' OR `type` LIKE '%".$word."%') AND members_id=".$_SESSION['id'].";";
        //echo $this->sql;
        $this->executeQuery();
    }
    
    
    
    /*
     * User Authentication.
     */
    public function login($email, $password, $stayLoggedIn)
    {
        $email = mysqli_real_escape_string($this->link, $email);
        $password = mysqli_real_escape_string($this->link, $password);
        $password = "anapatmuangcholfomfom" . (hash("sha256", $password) . "skKaoqi92#*3G93fc$^*S@@a2");
        $stayLoggedIn = mysqli_real_escape_string($this->link, $stayLoggedIn);
        $this->sql = "SELECT * FROM `members` WHERE `email` = '" . $email . "' AND `password` = '" . $password . "'";
        $this->executeQuery();
        if (mysqli_num_rows($this->result) == 1) {
            $row = mysqli_fetch_object($this->result);
            $_SESSION['id'] = $row->id;
            $_SESSION['name'] = $row->name;
            $_SESSION['pic'] = $row->pic;
            $_SESSION['permission'] = $row->permission;
            
            if ($stayLoggedIn == "true"){
                setcookie('id', $_SESSION['id'], time() + (86400 * 15), "/");
                setcookie('name', $_SESSION['name'], time() + (86400 * 15), "/");
                setcookie('pic', $_SESSION['pic'], time() + (86400 * 15), "/");
                setcookie('permission', $_SESSION['permission'], time() + (86400 * 15), "/");
            }
            
            return true;
        }
        //echo $this->sql;
        return false;
    }
    public function logout()
    {
        setcookie('id', $_SESSION['id'], time() - 3600, '/');
        setcookie('name', $_SESSION['name'], time() - 3600, '/');
        setcookie('pic', $_SESSION['pic'], time() - 3600, '/');
        setcookie('permission', $_SESSION['permission'], time() - 3600, '/');
        session_destroy();
    }

    /*
     * Registration.
     */
    public function add_user($email, $password, $name)
    {
        if (!empty($email) AND !empty($password) AND !empty($name)) {
            $email = mysqli_real_escape_string($this->link, $email);
            $password = mysqli_real_escape_string($this->link, $password);
            $name = mysqli_real_escape_string($this->link, $name);
            $this->sql = "INSERT INTO `members` (`email`, `password`, `name`) VALUES ('" . $email . "', '" . "anapatmuangcholfomfom" . (hash("sha256", $password) . "skKaoqi92#*3G93fc$^*S@@a2") . "', '" . $name . "');";
            $this->executeQuery();
            return true;
        } else {
            return false;
        }
    }
    public function checkEmailNonDupilcate($email){
        $email = mysqli_real_escape_string($this->link, $email);
        $this->sql = "SELECT * FROM `members` WHERE `email` = '" . $email . "'";
        //echo $this->sql;
        $this->executeQuery();
        if (mysqli_num_rows($this->result) == 0) {
            return true;
        }
        return false;
    }
    public function add_userPic($email, $password, $name, $pic)
    {
        if (!empty($email) AND !empty($password) AND !empty($name)) {
            $email = mysqli_real_escape_string($this->link, $email);
            $password = mysqli_real_escape_string($this->link, $password);
            $name = mysqli_real_escape_string($this->link, $name);
            $pic = mysqli_real_escape_string($this->link, $pic);
            $this->sql = "INSERT INTO `members` (`email`, `password`, `name`, `pic`) VALUES ('" . $email . "', '" . "anapatmuangcholfomfom" . (hash("sha256", $password) . "skKaoqi92#*3G93fc$^*S@@a2") . "', '" . $name . "', '" . $pic . "');";
            $this->executeQuery();
            return true;
        } else {
            return false;
        }
    }
}