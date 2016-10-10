<?php
$runtime_start = microtime(true);
require_once("include/conn.php");
$error = [
		'has_error' => "",
		'msg' => "",
	];
 if ($_SERVER['REQUEST_METHOD'] == "POST"){
$email = $_POST['email'];
$username = $_POST['username'];
$password = md5(trim($_POST['password']));
$hash = password_hash($password,PASSWORD_DEFAULT);
$sql = "INSERT INTO dm_user (username , password , email) VALUES ('{$username}', '{$hash}' , '{$email}')";
$sql1 = "SELECT * FROM dm_user WHERE email='{$email}'";
$query = $db -> query($sql1);
if(mysqli_num_rows($query) < 1)
{
$db -> query($sql);
$db -> close();
header('Location: login.php');
}
else
{
	$error['msg'] = "邮箱地址已存在.";
	$error['has_error'] = "has-error";
}
 }
?>
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    <title>注册-动漫新闻</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/signin.css" rel="stylesheet">
    <script src="js/ie-emulation-modes-warning.js"></script>
	<script type="text/javascript">
function getCookie(c_name)
{
if (document.cookie.length>0)
  {
  c_start=document.cookie.indexOf(c_name + "=")
  if (c_start!=-1)
    {
    c_start=c_start + c_name.length+1
    c_end=document.cookie.indexOf(";",c_start)
    if (c_end==-1) c_end=document.cookie.length
    return unescape(document.cookie.substring(c_start,c_end))
    }
  }
return ""
}

function setCookie(c_name,value,expiredays)
{
var exdate=new Date()
exdate.setDate(exdate.getDate()+expiredays)
document.cookie=c_name+ "=" +escape(value)+
((expiredays==null) ? "" : ";expires="+exdate.toGMTString())
}

function checkCookie()
{
username=getCookie('username')
if (username!=null && username!="")
  {window.location.href="admin.php"}
}
</script>
  </head>
<div class="container">
      <div class="alert alert-dismissible alert-danger" <?php if($error['has_error'] == "") echo 'style="display: none;"'; ?>>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>注册失败: </strong><?php echo $error['msg'] ?>
      </div>
 <body onload="checkCookie()">
<a class="glyphicon glyphicon-menu-left btn"  aria-hidden="true" href="index.php"></a>

    <div class="container">

      <form class="form-signin" method = "POST" action = "singin.php">
        <h2 class="form-signin-heading">请注册</h2>
		<div class="form-group <?php echo $error['has_error']?>">
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" name = "email" class="form-control" placeholder="Email address" required autofocus>
		</div>
		<div class="form-group <?php echo $error['has_error']?>">
		<label for="inputUesrname" class="sr-only">Uesrname</label>
		<input type="uesrname" id="inputUesrname" name = "username" class="form-control" placeholder="Username" required>
		</div>
		<div class="form-group <?php echo $error['has_error'];	$runtime_stop = microtime(true);?>">
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" name = "password" class="form-control" placeholder="Password" required>
		</div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">注册</button>
		<button class="btn btn-lg btn-block" type="button" onclick="javascript:window.location.href='login.php';">登录</button>
      </form>

    </div> <!-- /container -->
	  <footer>
		<div class="container">	  
        <p>© <a href="index.php">动漫新闻</a> 2016 Powered by dm_miemie</p>
		<p>打开本网页耗时：<?php echo round($runtime_stop-$runtime_start,6); ?>s &middot; 陈立制作 &middot; <a href="mailto:767471286@qq.com">Email联系：767471286@qq.com</a></p>
		</div>
      </footer>
    <script src="js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>