<?php
$runtime_start = microtime(true);
require_once("include/selectuser.php");
$error = [
		'has_error' => "",
		'msg' => "",
	];
if (!$_GET['newsid'] == null){
	$newsid = $_GET['newsid'];
}
else{
	header('Location:admin.php');
}
if ($_SERVER['REQUEST_METHOD'] == "POST"){	
	date_default_timezone_set("ETC/GMT-8");
	$content = htmlspecialchars(mysqli_real_escape_string($db, $_POST["editor"]));
	$pic = $_POST['pic'];
	$title = $_POST['title'];
	$time = date('y-m-d H:i:s',time());
	$type = $_POST['type'];
	$sql = "UPDATE dm_news SET time='{$time}',uid='{$rows["uid"]}',text='{$content}',tittle='{$title}',source='{$type}',pic='{$pic}' WHERE newsid='{$newsid}'";
	$db -> query($sql);
	$error['has_error'] = "has-error";
	$error['msg'] = "修改成功。";
}
$sql1="SELECT * FROM dm_news WHERE newsid = '{$newsid}'";
	$re = $db ->query($sql1);
	$res = $re ->fetch_assoc();
	$db -> close();
?>
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title><?php echo $res["tittle"]; ?>-动漫新闻后台管理-动漫新闻</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Custom styles for this template -->
    <link href="css/carousel.css" rel="stylesheet">
	<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
	<script src="js/sample.js"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  </head>
<!-- NAVBAR
================================================== -->
  <body id="main">
    <div class="navbar-wrapper">
      <div class="container">

        <nav class="navbar navbar-inverse navbar-static-top">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="admin.php">动漫新闻后台</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
              <ul class="nav navbar-nav">
                <li class="active"><a href="index.php">返回新闻前台</a></li>
                <li><a href="editnews.php">编辑新闻</a></li>
                <li><a href="userchange.php">编辑用户</a></li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $rows["username"]; ?> <span class="caret"></span></a>
                  <ul class="dropdown-menu">
					<li><a href="addnews.php">添加新闻</a></li>
                    <li><a href="userinfo.php">用户信息</a></li>
                    <li><a href="outlogin.php">退出</a></li>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
        </nav>

      </div>
<main>
 <div class="container">
      <div class="alert alert-dismissible alert-danger" <?php if($error['has_error'] == "") echo 'style="display: none;"'; ?>>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>修改结果: </strong><?php echo $error['msg'] ?>
      </div>
	<div class="adjoined-bottom">
<form action="<?php echo "edit.php?newsid=",$newsid; ?>" method = "post">
		<div>新闻标题： <label  class="sr-only">Email address</label>
        <input  name = "title" class="form-control" value="<?php echo $res["tittle"] ?>" required autofocus>
		</div>
		<div>新闻类型：<label  class="sr-only">Email address</label>
        <input  name = "type" class="form-control"value="<?php echo $res["source"] ?>" required autofocus>
		</div>
		<div>新闻图片：<label  class="sr-only">Email address</label>
        <input  name = "pic" class="form-control"  value="<?php echo $res["pic"] ?>">
		</div>
		<div>新闻内容：</div>
		<div class="grid-container">
			<div class="grid-width-100;">
				<textarea id="editor" name="editor">
					<?php echo $res["text"];	$runtime_stop = microtime(true); ?>
				</textarea>
			</div>
		</div>
			<input type = "submit" class="btn btn-default" />
		</form>
	</div>
<script>
	initSample();
</script>
</main>
      <footer>
		<div class="container">	  
        <p class="pull-right"><a href="#">返回顶部</a></p>
        <p>© <a href="index.php">动漫新闻</a> 2016 Powered by dm_miemie</p>
		<p>打开本网页耗时：<?php echo round($runtime_stop-$runtime_start,6); ?>s &middot; 陈立制作 &middot; <a href="mailto:767471286@qq.com">Email联系：767471286@qq.com</a></p>
		</div>
      </footer>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="js/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
