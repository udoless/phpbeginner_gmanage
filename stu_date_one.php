<?php
/**
*2012-8-3  |  By:NaV!
*/
//防止恶意调用
define('IN_GM',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','stu_date_one');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
//判断登录状态和权限
_login_state(2);
if($_GET['num']!=''){
	if(!$row=_fetch_array("SELECT * FROM gm_stuinfo AS s INNER JOIN gm_user AS u ON s.gm_num=u.gm_num WHERE s.gm_num='{$_GET['num']}'")){
		_alert_back('未找到你要查询的学生信息!');
	}
	if(!$row['gm_teacher']){
		$row['gm_teacher']='无  　';
		if($row['gm_active'])
			$row['gm_teacher'].=' <a href="teacher_match.php?action=one&num='.$row['gm_num'].'">现在分配</a>';
	}else{
		$row['gm_teacher'].=' <a href="teacher_match.php?action=one&num='.$row['gm_num'].'">重新分配</a>';
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
 	<dl>
 		<dt>学生个人信息<img src="photos<?php echo $row['gm_photoname']?>" /></dt>
 		<dd>姓名：<?php echo $row['gm_username']?></dd>
 		<dd>学号：<?php echo $row['gm_num']?></dd>
 		<dd>导师：<?php echo $row['gm_teacher']?></dd>
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
 		<dd><?php if($row['gm_active']=='0')echo "<input type='button' class='button' value='通 过' onclick=_confirm('确定审核通过吗？','stu_active.php?action=pass&num={$row['gm_num']}') />";?>　<input type="button" class="button" value="修 改" onclick="location.href='stu_data_edit.php?num=<?php echo $row['gm_num']?>'"/>　<input type="button" value="返 回" class="button" onclick="history.back()" /></dd>
 	</dl>
 </div>
</div>
<?php 
	require ROOT_PATH.'includes/footer_admin.inc.php';
?>
</body>
</html>