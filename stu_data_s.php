<?php
/**
*2012-8-22  |  By:NaV!
*/
//防止恶意调用
define('IN_GM',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','stu_data_s');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
//判断登录状态和权限
_login_state(1);
//个人信息
if($_GET['action']=='aboutme'){
	$row=_fetch_array("SELECT * FROM gm_stuinfo AS s INNER JOIN gm_user AS u ON s.gm_num=u.gm_num WHERE s.gm_num='{$_SESSION['num']}'");
}

//修改密码
if($_GET['action']=='pass_modify'){
	//引入验证文件
	include ROOT_PATH.'includes/register.func.php';
	$clean=array();
	$clean['password']=_check_password($_POST['password']);
	$clean['newpassword']=_check_password($_POST['newpassword']);
	//判断旧密码是否正确
	if(!_num_rows("SELECT gm_num FROM gm_user WHERE gm_active='1' AND gm_num = '{$_SESSION['num']}' AND gm_password = '{$clean['password']}'")){
		_alert_back('原密码不正确！');
	}
	if(_query("UPDATE gm_user SET gm_password = '{$clean['newpassword']}' WHERE gm_active='1' AND gm_num = '{$_SESSION['num']}'")){
	$string="密码修改成功！\\n用户名:{$_SESSION['username']}\\n登录帐号:{$_SESSION['num']}\\n密码：{$_POST['newpassword']}";
	_alert_back($string);		
}else{
	_alert_back('密码修改失败！');
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
 	<dl>
 		<dt>个人信息<img src="photos<?php echo $row['gm_photoname']?>" /></dt>
 		<dd>姓名：<?php echo $row['gm_username']?></dd>
 		<dd>学号：<?php echo $row['gm_num']?></dd>
 		<dd>导师：<?php echo $row['gm_teacher']?$row['gm_teacher']:'未分配'?></dd>
 		<dd>性别：<?php echo $row['gm_sex']?></dd>
 		<dd>出生年月：<?php echo $row['gm_birth']?></dd>
 		<dd>入学时间：<?php echo $row['gm_start_time']?></dd>
 		<dd>年级：<?php echo $row['gm_grade']?></dd>
 		<dd>联系方式：<?php echo $row['gm_contact']?></dd>
 		<dd>家庭住址：<?php echo $row['gm_address']?></dd>
 		<dd>专业：<?php echo $row['gm_subject']?></dd>
 		<dd>培养类型：<?php echo $row['gm_type']?></dd>
 		<dd>注册时间：<?php echo $row['gm_reg_time']?></dd>
 		<dd>上次登录时间：<?php echo $row['gm_last_time']?></dd>
 		<dd>上次登录IP：<?php echo $row['gm_last_ip']?></dd>
 		<dd><input type="button" value="返 回" class="button" onclick="history.back()" /></dd>
 	</dl>
 </div>

</div>
<?php 
	require ROOT_PATH.'includes/footer_student.inc.php';
?>
</body>
</html>