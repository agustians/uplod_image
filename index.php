<?php include'con.php';?>
<!DOCTYPE html>
<html>
<head>
 <title>Image Upload</title>
 <meta content="width=device-width, initial-scale=1" name="viewport"/>
 <style>
 *{margin:0;padding:0;}
 body{background:#efefef;color:#000000;font-size:16px;font-family:sans-serif;}
 .resize{max-width:1000px;width:100%;margin:0;padding:20px 25px;}
 .resize form{height:120px;background:#fff;padding:10px 10px;}
 .resize input[type=submit]{width:10%;border:none;padding:4px 0 4px 0;}
 .resize input[type=file]{height:30px;background:#fff;padding:8px 3px 0 3px;color:#000000;}
  .resize h1{text-transform:uppercase;font-style:inherit;width:100%;text-align:center;padding:10px 0 10px 0;background:#fff;border-bottom:2px solid #efefef;}
  .resize input[type=text]{display:block;height:30px;background:#fff;padding:4px 3px 2px 3px;color:#000000;}
  .resize form p{clear:both;}
  .orang{width:100%;padding:7px 0;}
  .orang h1{text-transform:uppercase;font-style:inherit;width:100%;text-align:center;background:#fff;border-bottom:2px solid #efefef;}
table{width:100%;background:#fff;}
table td{padding:5px 7px;width:25%;border:1px solid #efefef;}
@media(max-width:468px){
 .resize{width:83%;}
 .resize form{padding:5% 0 0 2%;}
 .resize input[type=submit]{left:6.5%;top:60%;clear:both;width:15%;}
 }
 </style>
</head>
<body>
<div class="resize">
<h1>Upload Gambar</h1>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
 {
$tempdir = 'upload/';
if (!file_exists($tempdir)) mkdir($tempdir, 0755);
$gamb =  $_FILES['gamb']['name'];
$valid = array("jpg","jpeg","png");
$image_tmp = $_FILES['gamb']['tmp_name'];
$path = $tempdir. $gamb;	
move_uploaded_file($image_tmp , $path);
$orang =$_POST['orang'];  
move_uploaded_file( $_FILES['gamb'] ['tmp_name'], $path); 
$stmt=$db->prepare("insert into gambar (gamb,orang,time)values(:gamb,:orang,:time) "); 
$stmt->execute(array(
':orang' => $orang,
':gamb' => $gamb,
':time' => date('Y-m-d H:i:s')
));
}   
?>
<form method="POST" enctype="multipart/form-data">
<p><input type="text" name="orang" placeholder="Masukan Nama"></p>
<p><input type="file" name="gamb" accept="image/*"></p>
<p><input type="submit" name="submit" value="Kirim"></p>
 </form>
<br/>
<div class="orang">
<h1>Keluaran</h1>
<?php
$stmt =$db->query('SELECT * FROM gambar ORDER BY id DESC');
while($row=$stmt->fetch()){
echo'<table>';
echo'<tr><td>'.$row['id'].'</td><td>'.$row['time'].'</td><td>'.$row['orang'].'</td><td><img height="50" width="50" src="upload/'.$row['gamb'].'"></img></td></tr>';
echo'</table>';
}?>
</div>
 </div>
</body>
</html>
