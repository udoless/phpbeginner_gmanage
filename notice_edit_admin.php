<?php
/**
*2012-8-2  |  By:NaV!
*/
//防止恶意调用
define('IN_GM',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','notice_edit_admin');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
//判断登录状态和权限
_login_state(2);
if($_GET['action']=='add' and $_POST['submit']=='提 交'){
	include ROOT_PATH.'includes/register.func.php';
	$clean = array();
	$clean['title'] = _check_title($_POST['title']);
	$clean['content'] =_check_content($_POST['content']);
	if(_query("INSERT INTO gm_notice(gm_title,gm_content,gm_write,gm_time) VALUES('{$clean['title']}','{$clean['content']}','{$_SESSION['num']}',NOW())")){
		_location('发布成功！','notice_admin.php');
	}else{
		_alert_back('发布失败！');
	}
}
if($_GET['action']=='edit' and $_GET['id']!=''){
	if(!$row=_fetch_array("SELECT * FROM gm_notice WHERE gm_id='{$_GET['id']}'")){
		_alert_back('未找到你要修改的公告！');
	}
	if($_POST['submit']=='提 交'){
		include ROOT_PATH.'includes/register.func.php';
		$clean = array();
		$clean['title'] = _check_title($_POST['title']);
		$clean['content'] =_check_content($_POST['content']);
		if($clean['title']==$row['gm_title'] and $clean['content']==$row['gm_content']){
			_location(null, 'notice_admin.php');
		}
		if(_query("UPDATE gm_notice SET gm_title='{$clean['title']}',gm_content='{$clean['content']}',gm_write='{$_SESSION['num']}',gm_time=NOW() WHERE gm_id='{$_GET['id']}'")){
			_location('修改成功！','notice_admin.php');
		}else{
		_alert_back('修改失败！');
		}
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
	<div id="main_in">
	<?php 
	   if($_GET['action']=='add')
	  	 echo '<form action="notice_edit_admin.php?action=add" method="post">';
	   elseif($_GET['action']=='edit' and $_GET['id']!='')
	     echo '<form action="notice_edit_admin.php?action=edit&id='.$_GET['id'].'" method="post">';	 
	   else{
	   	exit();
	   }	
	?>
		<dl>
		<dt>发布/修改/查看公告</dt>
		<dd>标题：<input type="text" name="title" value="<?php echo $row['gm_title']?>"/></dd>
		<dd><span>内容：</span><textarea name="content"><?php echo $row['gm_content']?></textarea></dd>
		<dd><input type="submit" name="submit" value="提 交" class="button"/><input type="button" value="返 回" class="button" onclick="location.href='notice_admin.php'" /></dd>
		</dl>
		</form>
	</div>
</div>
<?php 
	require ROOT_PATH.'includes/footer_admin.inc.php';
?>
</body>
</html>