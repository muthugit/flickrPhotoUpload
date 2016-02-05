<?php
     //Include phpFlickr
     require_once("phpFlickr.php");
echo 'reached';

     $error=0;
     $f = null;
     if($_POST){
echo 'post';
         if(!$_POST['name'] || !$_FILES["file"]["name"]){
             $error=1;

         }else{
echo $_POST['name'];
             if ($_FILES["file"]["error"] > 0){
echo '<br>File error';
                 echo "Error: " . $_FILES["file"]["error"] . "<br />";
             }else if($_FILES["file"]["type"] != "image/jpg" && $_FILES["file"]["type"] != "image/jpeg" && $_FILES["file"]["type"] != "image/png" && $_FILES["file"]["type"] != "image/gif"){
echo 'Error 3';
                 $error = 3;
             }else if(intval($_FILES["file"]["size"]) > 1525000){
echo 'Error 4';
                 $error = 4;
             }else{
                 $dir= dirname($_FILES["file"]["tmp_name"]);
                 $newpath=$dir."/".$_FILES["file"]["name"];
                 rename($_FILES["file"]["tmp_name"],$newpath);
                 //Instantiate phpFlickr
                 $status = uploadPhoto($newpath, $_POST["name"]);
                 if(!$status) {
                     $error = 2;
                 }
              }
          }
     }

     function uploadPhoto($path, $title) {
         $apiKey = "e0fb27a9db978169247afe3169afba43";
         $apiSecret = "d9a3f7d933ae7ccf";
         $permissions  = "write";
         $token        = "72157662014557483-df831fa3afbc5468";

         $f = new phpFlickr($apiKey, $apiSecret, true);
         $f->setToken($token);

         $result=$f->sync_upload($path, $title);
$photo=$f->photos_getInfo($result);

print_r($photo);

$src='http://farm'.$photo['photo']['farm'].'.staticflickr.com/'.$photo['photo']['server'].'/'.$photo['photo']['id'].'_'.$photo['photo']['secret'].'.'.$photo['photo']['originalformat'];

$src='https://c1.staticflickr.com/'.$photo['photo']['farm'].'/'.$photo['photo']['server'].'/'.$photo['photo']['id'].'_'.$photo['photo']['secret'].'_n.jpg';
echo '<br><img src="'.$src.'">';
     }
 ?>
