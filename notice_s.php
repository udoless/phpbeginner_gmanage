<?php
/**
*2012-8-22  |  By:NaV!
*/
//防止恶意调用
define('IN_GM',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','notice_s');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
//判断登录状态和权限
_login_state(1);
if($_GET['action']==''){	
	$num=_num_rows("SELECT * FROM gm_notice");
	//引入分页
	_page($num, $_system['notice_pagesize']);
	$res=_query("SELECT * FROM gm_notice ORDER BY gm_time DESC LIMIT $pagenum,$pagesize");
}
if($_GET['action']=='one' && $_GET['id']){
	if(!$row=_fetch_array("SELECT * FROM gm_notice WHERE gm_id='{$_GET['id']}'")){
		_alert_back("没有找到你要查看的公告！");
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
<div id="list">
	<?php 
	if($_GET['action']==''){
		if($num!=0){
			echo '<ul class="small">';
			echo '<li class="top">公告中心</li>';
			for($i=0;$i<$pagesize;$i++){
				$row=_fetch_array_list($res);
				if($row['gm_id']=='')
					break;
				echo '<li class="time">'.$row['gm_time'].'</li>';
				echo '<li class="title"><a href="notice_s.php?action=one&id='.$row['gm_id'].'">'.$row['gm_title'].'</a></li>';
				echo '<li class="line"></li>';
			}
			echo '</ul>';
		}else{
			echo "<center>暂时还没有任何公告</center>";
		}
		//引入分页		
		_paging($_system['notice_page']);
	}
	if($_GET['action']=='one' && $_GET['id']){
		echo '<ul>';
		echo '<li class="title_big">'.$row['gm_title'].'</li>';
		echo '<li class="time_big">'.$row['gm_time'].'</li>';
		
		echo '<li class="content">'.nl2br(str_replace(' ','&nbsp',$row['gm_content'])).'</li>';
		echo '</ul>';
		echo '<a href="notice_s.php" class="back">返回列表</a>';
	}
	?>
	
	</div>


</div>
<?php 
	require ROOT_PATH.'includes/footer_student.inc.php';
?>
</body>
</html>