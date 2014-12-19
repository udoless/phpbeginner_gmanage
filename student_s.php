<?php
/**
*2012-8-22  |  By:NaV!
*/
//防止恶意调用
define('IN_GM',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','student_s');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
//判断登录状态和权限
_login_state(1);
$notice_res=_query("SELECT * FROM gm_notice ORDER BY gm_time DESC LIMIT 12");
$message_res=_query("SELECT * FROM gm_message ORDER BY gm_systime DESC LIMIT 12");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="styles/student_s.css" rel="stylesheet" type="text/css" />
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
<div id="left">
	<dl>
		<dt>最新公告</dt>
		<?php 
		for($i=0;$i<12;$i++){
			$notice_row=_fetch_array_list($notice_res);
			if($notice_row['gm_id']=='')
				break;
			echo '<dd><a href="notice_s.php?action=one&id='.$notice_row['gm_id'].'">'._cut($notice_row['gm_title'],20).'</a></dd>';
		}
		?>
	</dl>
</div>
<div id="right">
	<dl>
		<dt> 最新留言</dt>
		<?php 
		for($i=0;$i<12;$i++){
			$message_row=_fetch_array_list($message_res);
			if($message_row['gm_id']=='')
				break;
			echo '<dd><span class="stu">'.$message_row['gm_username'].'</span><span class="time">于'.date('Y-m-d H:i',strtotime($message_row['gm_systime'])).' </span>'._cut($message_row['gm_content'],30).'</dd>';
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