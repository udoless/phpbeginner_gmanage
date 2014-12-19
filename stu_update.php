<?php
/**
*2012-8-3   By:NaV!
*/
//防止恶意调用
define('IN_GM',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','stu_update');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
//判断登录状态和权限
_login_state(2);
include ROOT_PATH.'includes/register.func.php';


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
<?php 
$sql="SELECT gm_username,gm_num,gm_start_time,gm_grade FROM gm_stuinfo";
$res=_query($sql);
$num=_num_rows($sql);
$fail=0;
echo "准备更新(含未审核的同学信息)......<br />";
for($i=0;$i<$num;$i++){
	$row=_fetch_array_list($res);
	$time=strtotime($row['gm_start_time']);
	$grade=_time_to_grade(date("Y",$time), date("m",$time));
	if(!_query("UPDATE gm_stuinfo SET gm_grade='$grade' WHERE gm_num='{$row['gm_num']}'")){
		echo "<font color=red>".$row['gm_username'].$row['gm_num']."信息更新失败！</font><br />";
		$fail++;
	}else{
	echo $row['gm_username']."(".$row['gm_num'].")信息更新成功！<br />";
	}
}

echo "<font color=blue>完毕！共更新".$num."位同学信息，成功：".($num-$fail)."个，失败：".$fail."个</font>";
?>

</div>
<?php 
	require ROOT_PATH.'includes/footer_admin.inc.php';
?>
</body>
</html>