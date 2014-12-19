<?php
/**
*2012-9-29  |  By:NaV!
*QQ:185877007
*/
//防止恶意调用
define('IN_GM',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','export');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
	require ROOT_PATH.'includes/title_admin.inc.php';
?>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header_admin.inc.php';
?>
<div id="main">
	<div id="main_in">
	 <fieldset>
	    <legend>数据导出</legend>
	    <form method="post" action="export_action.php">
	    选择数据：<select name='source'><option value="yjsxx">研究生信息</option><option value="dsxx">导师信息</option><option value="czjl">经费操作记录</option></select><br />
	    <br />
	   	<input type="submit" value="提 交" class="submit" name="submit"/>
	    </form>
	 </fieldset>   
	</div>

</div>
<?php 
	require ROOT_PATH.'includes/footer_admin.inc.php';
?>
</body>
</html>