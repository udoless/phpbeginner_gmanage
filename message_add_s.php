<?php
/**
*2012-8-22  |  By:NaV!
*/
//防止恶意调用
define('IN_GM',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','message_add_s');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
//判断登录状态和权限
_login_state(1);
if($_POST['submit']=="提 交"){
	include ROOT_PATH.'includes/register.func.php';
	$content =_check_content($_POST['content']);
	if(_query("INSERT INTO gm_message(gm_username,gm_num,gm_content,gm_systime)
		VALUES('{$_SESSION['username']}','{$_SESSION['num']}','$content',NOW())") or die(mysql_error())){
		_location("发布成功！","message_s.php");	
	}else{
		_alert_back("发布失败！");
	}	
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
	require ROOT_PATH.'includes/title_student.inc.php';
?>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header_student.inc.php';
?>
<div id="main">
	<div id="main_in">
		<form action="message_add_s.php?action=add" method="post">
			<dl>
			<dt>发布留言</dt>
			<dd>发布者：<input type="text" value="<?php echo $_SESSION['username']?>" disabled="disabled"/></dd>
			<dd><span>内　容：</span><textarea name="content"></textarea></dd>
			<dd><input type="submit" name="submit" value="提 交" class="button"/><input type="button" value="返 回" class="button" onclick="history.back()" /></dd>
			</dl>
		</form>
	</div>
</div>
<?php 
	require ROOT_PATH.'includes/footer_student.inc.php';
?>
</body>
</html>