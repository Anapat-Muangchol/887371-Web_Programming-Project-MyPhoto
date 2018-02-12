<?php

$imageupload = $_FILES['imageupload']['tmp_name'];
$imageupload_name = $_FILES['imageupload']['name'];
$pic = $_FILES['imageupload'];
echo $pic['tmp_name'][0]."<br>".$pic['name'][0];

if(isset($_POST['submit'])){
    if($imageupload){
        $fileCount = count($_FILES['imageupload']['name']);
        for ($i = 0; $i < $fileCount; $i++) {
            $arraypic = explode(".",$imageupload_name[$i]);//แบ่งชื่อไฟล์กับนามสกุลออกจากกัน
            $lastname = strtolower($arraypic);
            $filename = $arraypic[0];//ชื่อไฟล์
            $filetype = $arraypic[1];//นามสกุลไฟล์

            if($filetype=="jpg" || $filetype=="jpeg" || $filetype=="png" || $filetype=="gif"){
                $newimage = $filename.".".$filetype;//รวมชื่อไฟล์กับนามสกุลเข้าด้วยกัน
                copy($imageupload[$i],"uploads/".$newimage); //โฟลเดอร์สำหรับเก็บรูป/ไฟล์รูป
            }else {
                echo "<h3>ERROR : ไม่สามารถ Upload รูปภาพ</h3>";
            }
            $showpic = "uploads/".$newimage;
        }
    }
}

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title></title>
    <style>
        body{background: #eeeeee;margin:0 auto;}
        #form_upload{margin:0px auto;}
        #showimage{margin:100px auto 20px auto;}
    </style>
</head>
<body>
<center><div id="showimage">
        <?php if($_POST[submit]){ echo "<img width=150 src='$showpic'";}?>
    </div></center>

<div id="form_upload">
    <form method="post" enctype="multipart/form-data">
        <center> Image: <input type="file" name="imageupload[]" accept="image/x-png, image/gif, image/jpeg, image/jpg" multiple/>
            <input type="submit" name="submit" value="Upload"/></center>
    </form>
</div>
</body>
</html>  