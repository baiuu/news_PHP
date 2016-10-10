<?php
$runtime_start = microtime(true);
require_once("include/selectuser.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE);
 ini_set('date.timezone','Asia/Shanghai');


// 根据不同系统取得CPU相关信息
switch(PHP_OS) {
	case "Linux":
		$sysReShow = (false !== ($sysInfo = sys_linux()))?"show":"none";
		break;
	case "FreeBSD":
		$sysReShow = (false !== ($sysInfo = sys_freebsd()))?"show":"none";
		break;
	case "WINNT":
		$sysReShow = (false !== ($sysInfo = sys_windows()))?"show":"none";
		break;
	default:
		break;
}

//windows系统探测
function sys_windows() {
	if (PHP_VERSION >= 5) {
		$objLocator = new COM("WbemScripting.SWbemLocator");
		$wmi = $objLocator->ConnectServer();
		$prop = $wmi->get("Win32_PnPEntity");
	} else {
		return false;
	}

	//CPU
	$cpuinfo = GetWMI($wmi,"Win32_Processor", array("Name","L2CacheSize","NumberOfCores"));
	$res['cpu']['num'] = $cpuinfo[0]['NumberOfCores'];
	if (null == $res['cpu']['num']) {
		$res['cpu']['num'] = 1;
	}
	for ($i=0;$i<$res['cpu']['num'];$i++){
		$res['cpu']['model'] .= $cpuinfo[0]['Name']."<br />";
		$res['cpu']['cache'] .= $cpuinfo[0]['L2CacheSize']."<br />";
	}
	// SYSINFO
	$sysinfo = GetWMI($wmi,"Win32_OperatingSystem", array('LastBootUpTime','TotalVisibleMemorySize','FreePhysicalMemory','Caption','CSDVersion','SerialNumber','InstallDate'));
	//UPTIME
	$res['uptime'] = $sysinfo[0]['LastBootUpTime'];

	$sys_ticks = 3600*8 + time() - strtotime(substr($res['uptime'],0,14));
	$min = $sys_ticks / 60;
	$hours = $min / 60;
	$days = floor($hours / 24);
	$hours = floor($hours - ($days * 24));
	$min = floor($min - ($days * 60 * 24) - ($hours * 60));
	if ($days !== 0) $res['uptime'] = $days."天";
	if ($hours !== 0) $res['uptime'] .= $hours."小时";
	$res['uptime'] .= $min."分钟";

	//MEMORY
	$res['memTotal'] = $sysinfo[0]['TotalVisibleMemorySize'];
	$res['memFree'] = $sysinfo[0]['FreePhysicalMemory'];
	$res['memUsed'] = $res['memTotal'] - $res['memFree'];
	$res['memPercent'] = round($res['memUsed'] / $res['memTotal']*100,2);

	$swapinfo = GetWMI($wmi,"Win32_PageFileUsage", array('AllocatedBaseSize','CurrentUsage'));

	// LoadPercentage
	$loadinfo = GetWMI($wmi,"Win32_Processor", array("LoadPercentage"));
	$res['loadAvg'] = $loadinfo[0]['LoadPercentage'];

	return $res;
}

function GetWMI($wmi,$strClass, $strValue = array()) {
	$arrData = array();

	$objWEBM = $wmi->Get($strClass);
	$arrProp = $objWEBM->Properties_;
	$arrWEBMCol = $objWEBM->Instances_();
	foreach($arrWEBMCol as $objItem) {
		@reset($arrProp);
		$arrInstance = array();
		foreach($arrProp as $propItem) {
			eval("\$value = \$objItem->" . $propItem->Name . ";");
			if (empty($strValue)) {
				$arrInstance[$propItem->Name] = trim($value);
			} else {
				if (in_array($propItem->Name, $strValue)) {
					$arrInstance[$propItem->Name] = trim($value);
				}
			}
		}
		$arrData[] = $arrInstance;
	}
	return $arrData;
}


//比例条
function bar($percent) {
?>
<div class="bar"><div class="barli" style="width:<?=$percent?>%">&nbsp;</div></div>
<?php
}
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

    <title>动漫新闻后台管理-动漫新闻</title>

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
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style type="text/css">
<!--
body{background-color:#FFFFFF;font-size:12px;font-family:Tahoma,Arial}
a{text-decoration:none}
table{clear:both;margin-bottom:5px;border-collapse:collapse;}
th{font-weight:bold;background:#7694BF;color:white;}
tr{background:#F1F4F7}
td{border:1px solid white}
input{border:1px solid #333;font-size:12px}
.bar {border:1px solid #999;height:5px;font-size:2px;width:60%;}
.barli{background:#FFCC00;height:5px;margin:0;padding:0;}
-->
</style>
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
<table width="96%" cellpadding="5" cellspacing="1" align="center">
  <tr><th colspan="4">服务器参数</th></tr>
  <tr>
    <td>用户 - 服务器</td>
    <td colspan="3"><?php echo @get_current_user();?> - <?php echo $_SERVER['SERVER_NAME'];?>(<?php echo gethostbyname($_SERVER['SERVER_NAME']);?>)</td>
  </tr>
  <tr>
    <td>服务器解译引擎</td>
    <td colspan="3"><?php echo $_SERVER['SERVER_SOFTWARE'];?></td>
  </tr>
  <tr>
    <td>服务器标识</td>
    <td colspan="3"><?php if($sysInfo['win_n'] != ''){echo $sysInfo['win_n'];}else{echo @php_uname();};?></td>
  </tr>
  <tr>
    <td width="13%">服务器时间</td>
    <td width="37%"><?php echo gmdate("Y年n月j日 H:i:s",time()+8*3600);?></td>
    <td width="13%">可用空间(磁盘区)</td>
    <td width="37%"><?php echo round(disk_free_space(".")/(1024*1024),2);?>&nbsp;M</td>
  </tr>
  <tr>
    <td>服务器语言</td>
    <td><?php echo getenv("HTTP_ACCEPT_LANGUAGE");?></td>
    <td>服务器端口</td>
    <td><?php echo $_SERVER['SERVER_PORT'];?></td>
  </tr>
  <tr>
	  <td>绝对路径</td>
	  <td><?php echo $_SERVER['DOCUMENT_ROOT']. "<br />".$_SERVER['$PATH_INFO'];?></td>
	</tr>
	<?if("show"==$sysReShow){?>
  <tr><th colspan="4">服务器CPU及内存相关运行参数</th></tr>
  <tr>
    <td>CPU核数</td>
    <td><?php echo $sysInfo['cpu']['num'];?>&nbsp;</td>
    <td>服务器已运行时间</td>
	  <td><?php echo $sysInfo['uptime'];?></td>
  </tr>
  <tr>
    <td>CPU型号</td>
    <td><?php echo $sysInfo['cpu']['model'];?></td>
    <td>CPU二级缓存</td>
    <td><?php echo $sysInfo['cpu']['cache'];?></td>
  </tr>
	  <tr>
		<td>内存使用状况</td>
		<td colspan="3"> 物理内存：
			共<?php echo $sysInfo['memTotal'];?>M,
		  已使用<?php echo $sysInfo['memUsed'];?>M(其中Cache化内存为<?php echo $sysInfo['memCached'];?>M,),
			空闲<?php echo $sysInfo['memFree'];?>M<br />
			含Cache化内存的使用率<?php echo $sysInfo['memPercent'];?>%(注明:类似Apache等WEB Application Server会开辟Cache化内存加速存取)
			<?php echo bar($sysInfo['memPercent']);	$runtime_stop = microtime(true);?>
	  </td>
	</tr>
  <?}?>
</table>
</div>
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
