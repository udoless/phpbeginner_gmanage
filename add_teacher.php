<?php
/**
*2012-9-12   By:NaV!
*/
//防止恶意调用
define('IN_GM',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','add_teacher');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
if($_GET['action']==add){
	if($_POST['submit']=='提 交'){
	include ROOT_PATH.'includes/register.func.php';
	$name=_check_username($_POST['name']);
	$num=_check_num($_POST['num']);
	$zc=$_POST['zc'];
	if(_query("INSERT INTO gm_teacher(gm_num,gm_username,gm_zc) VALUES('$num','$name','$zc')")){
		_alert_back("添加成功！");
	}else{
		_alert_back("添加失败！");
	}
	}
}
if($_GET['action']==modify){
	if($_GET['num'])
		$row=_fetch_array("SELECT * FROM gm_teacher WHERE gm_num='{$_GET['num']}'");
	if($_POST['submit']=='提 交'){
		include ROOT_PATH.'includes/register.func.php';
		$name=_check_username($_POST['name']);
		$num=_check_num($_POST['num']);
		$zc=$_POST['zc'];
		if(_query("UPDATE gm_teacher SET gm_username='$name',gm_zc='$zc' WHERE gm_num='$num'")){
			_alert_back("修改成功！");
		}else{
			_alert_back("修改失败！");
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
 <fieldset>
 <?php if($_GET['action']==modify){
 			echo '<legend>修改导师资料</legend>';
 			echo ' <form method="post" action="add_teacher.php?action=modify">';
		 }
 		if($_GET['action']==add){	
 			echo '<legend>添加导师</legend>';
 			echo ' <form method="post" action="add_teacher.php?action=add">';
 		 }
 ?>  
   
    姓名：<input type="text" name="name" value='<?php echo $row['gm_username']?>' /><br />
    工号：<input type="text" name="num" <?php if($_GET['action']==modify)echo 'disabled="disabled"'; ?> id="inputDetails" value='<?php echo $row['gm_num']?>' /><br /> 
 <?php if($_GET['action']==modify)echo '<input type="hidden" name="num" value='.$row['gm_num'].' />';?>  
    职称：<select name="zc"><option>教授</option><option <?php if($row['gm_zc']=='副教授')echo 'selected=selected';?>>副教授</option></select><br />
   	<input type="submit" value="提 交" name="submit" class="submit"/>
    </form>
 </fieldset>   
</div>

</div>
<?php 
	require ROOT_PATH.'includes/footer_admin.inc.php';
?>
</body>
</html>