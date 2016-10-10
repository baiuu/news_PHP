<?php 
require_once("include/selectuser.php");
if(!isset($_GET["newsid"])){
	if(!isset($_GET["uid"])){
		header('Location:admin.php');}
		$uid = $_GET['uid'];
		$sql = "DELETE FROM dm_user WHERE uid='{$uid}'";
}
else{
	$newsid = $_GET['newsid'];
	$sql = "DELETE FROM dm_news WHERE newsid='{$newsid}'";
}
$db ->query($sql);
$db -> close();
echo "<script> {window.alert('删除成功');location.href='admin.php'} </script>";
?>