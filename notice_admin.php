<?php
/**
*2012-8-2  |  By:NaV!
*/
//防止恶意调用
define('IN_GM',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','notice_admin');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
//判断登录状态和权限
_login_state(2);
if($_GET['action']==''){	
	$num=_num_rows("SELECT * FROM gm_notice");
	//引入分页
	_page($num, $_system['notice_pagesize']);
	$res=_query("SELECT * FROM gm_notice ORDER BY gm_time DESC LIMIT $pagenum,$pagesize");
}elseif($_GET['action']=='del' and $_GET['id']!=''){
	if(_query("DELETE FROM gm_notice WHERE gm_id='{$_GET['id']}'")){
		_alert_back('删除成功！');
	}else{
		_alert_back('删除失败！');
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
	<?php 
	if($_GET['action']==''){
		if($num!=0){
			echo '<ul>';
			echo '<li class="top">公告中心</li>';
			for($i=0;$i<$pagesize;$i++){
				$row=_fetch_array_list($res);
				if($row['gm_id']=='')
					break;
				$row['gm_title']=_cut($row['gm_title'], 46);	
				echo '<li class="time">'.$row['gm_time'].'</li>';
				echo "<li class='title'><a href='notice_edit_admin.php?action=edit&id={$row['gm_id']}'>{$row['gm_title']}</a>　<span><a href='###' onclick=\"_confirm('确定删除这条公告吗？','notice_admin.php?action=del&id={$row['gm_id']}')\">[删除]</a> <a href='notice_edit_admin.php?action=edit&id={$row['gm_id']}'>[修改]</a></span></li>";
				echo '<li class="line"></li>';
			}
			echo '</ul>';
		}else{
			echo "<center>暂时还没有任何公告</center>";
		}
		//引入分页		
		_paging($_system['notice_page']);
	}
	?>
	</div>
</div>
<?php 
	require ROOT_PATH.'includes/footer_admin.inc.php';
?>
</body>
</html>