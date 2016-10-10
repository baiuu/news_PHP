<?php
	$runtime_start = microtime(true);
	require_once("include/conn.php");
	$sql = "SELECT * FROM dm_news WHERE pic IS NOT NULL AND pic <>'' ORDER BY RAND() LIMIT 3";
	$sql1 = "SELECT * FROM dm_news WHERE pic IS NOT NULL AND pic <>'' ORDER BY newsid DESC LIMIT 0,3";
	$ne = $db ->query($sql1);
	$nes = $db ->query($sql);
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

    <title>动漫新闻</title>

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
  <body>
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
              <a class="navbar-brand" href="index.php">动漫新闻</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
              <ul class="nav navbar-nav">
                <li class="active"><a href="table.php?type=1">动漫资讯</a></li>
				<li class="active"><a href="table.php?type=2">小说资讯</a></li>
				<li class="active"><a href="table.php?type=3">游戏资讯</a></li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">后台管理 <span class="caret"></span></a>
                  <ul class="dropdown-menu">
					<li><a href="login.php">登陆</a></li>
                    <li><a href="singin.php">注册</a></li>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
        </nav>

      </div>
    </div>

	

    <!-- Carousel
    ================================================== -->
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner" role="listbox">
	  <?php 
	   $i=0;
	  while ($re = $nes ->fetch_assoc()) {
		if($i==0)
		{
       echo "<div class='item active'>";
	   $i=1;
		}
		else
		{
		echo "<div class='item'>";
		}
       echo "<img class='first-slide' src='{$re['pic']}'>";
       echo "<div class='container'>";
       echo "<div class='carousel-caption'>";
       echo "<h1>{$re['tittle']}</h1>";
	  $tt = $re['text'];
	  $tt = preg_replace('/<[^>]+>/','',html_entity_decode($tt));
	  $tt = mb_substr($tt,0,40,'utf-8');
       echo  "<p>{$tt}</p>";
       echo "<p><a class='btn btn-lg btn-primary' href='news.php?newsid={$re['newsid']}' role='button'>预览</a></p>";
       echo "</div>";
       echo "</div>";
       echo "</div>";
	   }
		?>
      </div>
      <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div><!-- /.carousel -->

 <div class="container marketing">

      <!-- Three columns of text below the carousel -->
      <div class="row">
        <div class="col-lg-4">
          <img class="img-circle" src="/images/type1.jpg" alt="Generic placeholder image" width="140" height="140">
          <h2>动漫资讯</h2>
          <p>动漫资讯依托于动漫资讯网站，是以报道综合最新动漫资讯，动漫周边和日本御宅族文化动态为主。有时也会报道世界其他地方的类似动漫新闻动态。它提供新闻阅读与评论，使动漫爱好者之间能够互动交流。</p>
          <p><a class="btn btn-default" href="table.php?type=1" role="button">查看 &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
          <img class="img-circle" src="/images/type2.jpg" alt="Generic placeholder image" width="140" height="140">
          <h2>小说资讯</h2>
          <p>以刻画人物形象为中心，通过完整的故事情节和环境描写来反映社会生活的文学体裁。</p>
          <p><a class="btn btn-default" href="table.php?type=2" role="button">查看 &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
          <img class="img-circle" src="/images/type3.jpg" alt="Generic placeholder image" width="140" height="140">
          <h2>游戏资讯</h2>
          <p>游戏是幻想与现实之间的桥梁。游戏有智力游戏和活动性游戏之分，又翻译为Play，Pastime，Playgame，Sport，Spore，Squail，Games，Gamest，Hopscotch，Jeu，Toy体育运动的一类。现在的游戏多指各种平台上的电子游戏。</p>
          <p><a class="btn btn-default" href="table.php?type=3" role="button">查看 &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
      </div><!-- /.row -->
    <!-- Marketing messaging and featurettes
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->

    <div class="container marketing">
<?php
	while ($res = $ne ->fetch_assoc()) {
	  echo "<hr class='featurette-divider'>";
      echo "<a class='row featurette' href='news.php?newsid={$res['newsid']}'>";
      echo "<div class='col-md-7'>";
      echo "<h2 class='featurette-heading'>{$res['tittle']}</h2>";
	  $text = $res['text'];
	  $text = preg_replace('/<[^>]+>/','',html_entity_decode($text));
	  $text = mb_substr($text,0,40,'utf-8');
      echo "<p class='lead'>{$text}...</p>";
      echo "</div>";
      echo "<div class='col-md-5'>";
      echo "<img class='featurette-image img-responsive center-block' src='{$res['pic']}' alt='Generic placeholder image'>";
      echo "</div>";
      echo "</a>";
	}
	$runtime_stop = microtime(true);
?>

      <!-- /END THE FEATURETTES -->


      <!-- FOOTER -->
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
