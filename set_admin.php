<?php
/**
*2012-8-23   By:NaV!
*/
//防止恶意调用
define('IN_GM',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','set_admin');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
//判断登录状态和权限
_login_state(3);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
	require ROOT_PATH.'includes/title_admin.inc.php';
?>
<script src="js/set.js" type="text/javascript"></script>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header_admin.inc.php';
?>
<div id="main">
	<div id="left">
		<h2>管理导航</h2>
		<dl>
			<dt>系统管理</dt>
			<dd><a href="set_admin.php">后台首页</a></dd>
			<dd><a href="###" id="sysset">系统设置</a></dd>
		</dl>
		<dl>
			<dt>页面设置</dt>
			<dd><a href="###" id="page">分页设置</a></dd>
			<dd><a href="###" id="csstype">风格设置</a></dd>
		</dl>
	</div>
	<div id="right">
		<h2>后台管理中心</h2>
		<div id="right_in">
		<dl>
			<dd>·服务器主机名称：<?php echo $_SERVER['SERVER_NAME']; ?></dd>
			<dd>·通信协议名称/版本：<?php echo $_SERVER['SERVER_PROTOCOL']; ?></dd>
			<dd>·服务器IP：<?php echo !$_SERVER["SERVER_ADDR"]?未知:$_SERVER["SERVER_ADDR"]; ?></dd>
			<dd>·客户端IP：<?php echo $_SERVER["REMOTE_ADDR"]; ?></dd>
			<dd>·服务器端口：<?php echo $_SERVER['SERVER_PORT']; ?></dd>
			<dd>·客户端端口：<?php echo !$_SERVER["REMOTE_PORT"]?未知:$_SERVER["REMOTE_PORT"]; ?></dd>
			<dd>·管理员邮箱：<?php echo !$_SERVER['SERVER_ADMIN']?未知:$_SERVER['SERVER_ADMIN'] ?></dd>
			<dd>·Host头部的内容：<?php echo $_SERVER['HTTP_HOST']; ?></dd>
			<dd>·服务器主目录：<?php echo $_SERVER["DOCUMENT_ROOT"]; ?></dd>
			<dd>·脚本执行的绝对路径：<?php echo $_SERVER['SCRIPT_FILENAME']; ?></dd>
			<dd>·Apache及PHP版本：<?php echo $_SERVER["SERVER_SOFTWARE"]; ?></dd>
		</dl>
		</div>
	</div>

</div>
<?php 
	require ROOT_PATH.'includes/footer_admin.inc.php';
?>
</body>
</html>