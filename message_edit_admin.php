<?php
/**
*2012-8-2  |  By:NaV!
*/
//防止恶意调用
define('IN_GM',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','message_edit_admin');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
//判断登录状态和权限
_login_state(2);
//取出留言内容
if($_GET['action']=='edit' and !$row=_fetch_array("SELECT * FROM gm_message WHERE gm_id = '{$_GET['id']}'")){
	_alert_back('没有取出任何留言内容！');
}
if($_GET['action']=='process' and $_GET['id']!='' ){
	if($_POST['reply']==''){
		_location(null, 'message_admin.php');
	}
	if(!$row=_fetch_array("SELECT gm_content,gm_reply FROM gm_message WHERE gm_id='{$_GET['id']}'")){
		_alert_back('未找到你要编辑/回复的留言！');
	}
	include ROOT_PATH.'includes/register.func.php';
	$clean = array();
	$clean['content'] =_check_content($_POST['content']);
	$clean['reply'] = _check_content($_POST['reply']);
	if($clean['content']==$row['gm_content'] and $clean['reply']==$row['gm_reply']){
			_location(null,'message_admin.php');
		}
	if(_query("UPDATE gm_message SET gm_content='{$clean['content']}',gm_reply='{$clean['reply']}',gm_replytime=NOW() WHERE gm_id='{$_GET['id']}'")){
		_location('回复成功！','message_admin.php');		
	}else{
		_alert_back('回复失败！');
	}
}
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
	<div id="list">
		<div id="listmain">
			<p><img src="images/i1.gif" /><img src="images/edit.gif" /></p>
			<h2>
			<img src="images/icon_write.gif" /><?php echo $row['gm_username']?>
			<font style="color:#999;">于<?php echo $row['gm_systime']?> 发布的留言</font>
			</h2>
			<form action="message_edit_admin.php?action=process&id=<?php echo $_GET['id']?>" method="post">
				<textarea name="content"><?php echo $row['gm_content']?></textarea>
				<h2>回复内容:</h2>
				<textarea name="reply"><?php echo $row['gm_reply']?></textarea>
				<input class="button" type="submit" value="编辑/回复"/>　<input type="button" value="返 回" class="button" onclick="history.back()" />
			</form>
		</div>
	</div>
</div>
<?php 
	require ROOT_PATH.'includes/footer_admin.inc.php';
?>
</body>
</html>