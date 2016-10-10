<?php
$runtime_start = microtime(true);
require_once("include/selectuser.php");
$error = [
		'has_error' => "",
		'msg' => "",
	];
if ($_GET == null){
$page = 1;}
else{
$page=$_GET['page']; //获得当前的页面值
}
$perNumber=10; //每页显示的记录数
$sql1 = "SELECT count(*) FROM dm_user";
$count=$db -> query($sql1); //获得记录总数
$rs=mysqli_fetch_array($count); 
$totalNumber=$rs[0];
$totalPage=ceil($totalNumber/$perNumber); //计算出总页数
if (!isset($page)) {
 $page=1;
} //如果没有值,则赋值1
$startCount=($page-1)*$perNumber; //分页开始,根据此方法计算出开始的记录
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

    <title>用户编辑-动漫新闻后台管理-动漫新闻</title>

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
    <?php
	$sql="SELECT * FROM dm_user limit $startCount,$perNumber";
	$re = $db ->query($sql);
	echo "<div id='table'><table><tr>";
	echo "<th>用户名：</th>";
	echo "<th>邮箱：</th>";
	echo "<th>操作</th></tr>";
	while ($res = $re ->fetch_assoc()) {
	echo "<tr><td>",$res['username'],"</td>";
	echo "<td>",$res['email'],"</td>";
	echo "<td><a href='edituser.php?uid={$res['uid']}'>编辑</a><a href='del.php?uid={$res['uid']}'>删除</a></td></tr>"; //显示数据库的内容
}
	$db -> close();
	echo "</table>";
	echo "</div>";
	if ($page != 1) { //页数不等于1
echo "<a href='userchange.php?page=<?php echo $page - 1;?>'>上一页</a>";
}
if($page >1&&$totalPage>5){
echo "...";
if($totalPage-$page>=4)
{
for ($i=$page;$i<=$page+4&&$i<=$totalPage;$i++) {
echo "<a href='userchange.php?page={$i}'>[{$i}]</a>";
}
}
else{
for ($i=$totalPage-4;$i<=$page+4&&$i<=$totalPage;$i++) {
echo "<a href='userchange.php?page={$i}'>[{$i}]</a>";
}
}
}
else{
for ($i=1;$i<=5&&$i<=$totalPage;$i++) {  //循环显示出页面
echo "<a href='userchange.php?page={$i}'>[{$i}]</a>";
}
}
if ($totalPage > 5&&$totalPage-$page>4){
	echo "...";
}
if ($page<$totalPage) { //如果page小于总页数,显示下一页链接
{
	$nextpage=$page+1;
	echo "<a href='userchange.php?page={$nextpage}'>下一页</a>";
}
}
	$runtime_stop = microtime(true);
	?>
	</div>
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
