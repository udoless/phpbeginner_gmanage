<?php
/**
*2012-8-19  |  By:NaV!
*/
//防止恶意调用
define('IN_GM',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','funds_add_admin');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
//判断登录状态和权限
_login_state(2);
////引入资金专用函数库
//require dirname(__FILE__).'/includes/funds.func.php';
//if($_GET['action']=="condition"){
//$get=_check_post($_POST);
//	if($num=_num_rows("SELECT * FROM gm_stuinfo WHERE $get AND gm_active='1'")){
//		$rows=_fetch_array("SELECT * FROM gm_stuinfo WHERE $get AND gm_active='1'");
//		for($i=0;$i<$num;$i++){
//			$content.="<span>{$rows['num']}</span>";
//		}
//	}
//}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
	require ROOT_PATH.'includes/title_admin.inc.php';
?>
<script type="text/javascript" src="js/funds_add.js"></script>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header_admin.inc.php';
?>
<div id="main">
<div id="top">
<p>操作类型：<span class="type" id="one">导师</span><span class="type" id="two">学生</span></p>
</div>
<div id="center"></div>
<div id="bottom"></div>
<div id="last"></div>
<div id="details"></div>


</div>
<?php 
	require ROOT_PATH.'includes/footer_admin.inc.php';
?>
</body>
</html>