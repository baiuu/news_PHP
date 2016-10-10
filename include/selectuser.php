<?php
session_start(); 
if(isset($_COOKIE['username']))
{
require_once("include/conn.php");
$sql = "SELECT * FROM dm_user WHERE cookies='{$_COOKIE['username']}'";
$user = $db -> query($sql);
$rows = $user->fetch_assoc();
if(!$_COOKIE['username']==$rows['cookies'])
{
	setcookie("username"); 
	header('Location:login.php');
}
}
else
{
	header('Location:login.php');
}
?>