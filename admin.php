<?php
/**
*2012-7-30  |  By:NaV!
*/
//防止恶意调用
define('IN_GM',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','admin');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
//判断登录状态和权限
_login_state(2);

$active_num=_num_rows("SELECT gm_id FROM gm_stuinfo WHERE gm_active='0'");
$message_num=_num_rows("SELECT gm_id FROM gm_message WHERE (NOW()-gm_systime)<12*3600");
$message_re_num=_num_rows("SELECT gm_id FROM gm_message WHERE gm_replytime is null");
$teacher_mat_num=_num_rows("SELECT gm_id FROM gm_stuinfo WHERE (gm_teacher is null OR gm_teacher='') AND gm_active='1' ");
$funds_num=_num_rows("SELECT gm_fid FROM gm_funds");
$user_num=_num_rows("SELECT gm_id FROM gm_user WHERE gm_active='1'");
$stu_num=_num_rows("SELECT gm_id FROM gm_stuinfo WHERE gm_active='1'");
$message_res=_query("SELECT * FROM gm_message ORDER BY gm_systime DESC LIMIT 8");
$teacher_num=_num_rows("SELECT gm_id FROM gm_teacher");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="styles/admin.css" rel="stylesheet" type="text/css" />
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
<div id="left">
	<dl>
		<dt>统计信息</dt>
		<dd><a href="stu_active.php">发现有<?php echo $active_num?>名学生需要审核</a></dd>
		<dd><a href="message_admin.php">发现有<?php echo $message_num?>条最新的留言</a></dd>
		<dd><a href="message_admin.php?action=some">发现有<?php echo $message_re_num?>条留言未回复</a></dd>
		<dd><a href="teacher_match.php?action=some">发现有<?php echo $teacher_mat_num?>位学生未分配导师</a></dd>
		<dd><a href="funds_admin.php">共有<?php echo $funds_num?>条经费记录</a></dd>
		<dd><a href="user_data.php">共有<?php echo $user_num?>个可登录用户</a></dd>
		<dd><a href="stu_date.php">共有<?php echo $stu_num?>个研究生信息</a></dd>
		<dd><a href="teacher_data.php">共有<?php echo $teacher_num?>个导师信息</a></dd>	
	</dl>
</div>
<div id="right">
	<dl>
		<dt> 最新留言</dt>
		<?php 
		for($i=0;$i<8;$i++){
			$message_row=_fetch_array_list($message_res);
			if($message_row['gm_id']=='')
				break;
			echo '<dd><span class="stu"><a href="stu_date_one.php?num='.$message_row['gm_num'].'">'.$message_row['gm_username'].'</a></span><span class="time">于'.date('Y-m-d H:i',strtotime($message_row['gm_systime'])).' </span><a href="message_edit_admin.php?action=edit&id='.$message_row['gm_id'].'">'._cut($message_row['gm_content'],25).'</a>';
			if($message_row['gm_replytime']==NULL)
				echo '　[<i>未回复</i>]';
			
			echo '</dd>';
		}
		?>

	</dl>
</div>    
</div>
<?php 
	require ROOT_PATH.'includes/footer_admin.inc.php';
?>

</body>
</html>









