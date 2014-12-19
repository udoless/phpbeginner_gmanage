<?php
/**
*2012-7-31  |  By:NaV!
*/
//防止恶意调用
define('IN_GM',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','stu_active');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
//判断登录状态和权限
_login_state(2);
//判断是否有学生需要审核
if($num=_num_rows("SELECT gm_active FROM gm_stuinfo WHERE gm_active='0'")){
	//分页模块
	_page($num,$_system['stu_active_pagesize']);
	$res=_query("SELECT gm_active,gm_username,gm_num,gm_sex,gm_grade,gm_subject,gm_type FROM gm_stuinfo WHERE gm_active='0' ORDER BY gm_num LIMIT $pagenum,$pagesize");
}
//开始激活和删除处理
if(!empty($_GET['num']) and !empty($_GET['action'])){
	//判断传过来的学号是否真实存在
	if (_fetch_array("SELECT gm_active FROM gm_stuinfo WHERE gm_num='{$_GET['num']}' LIMIT 1")){
		//激活
		if($_GET['action']==pass){
		if(_query("UPDATE gm_stuinfo SET gm_active='1' WHERE gm_num='{$_GET['num']}'") and _query("UPDATE gm_user SET gm_active='1' WHERE gm_num='{$_GET['num']}'")){
			_location('审核成功！', 'stu_active.php');
		}else{
			_location('审核失败！', 'stu_active.php');
		}
		}
		//删除
		if($_GET['action']==del){
		if(_query("DELETE FROM gm_user WHERE gm_num='{$_GET['num']}'")){
			$r_s=_fetch_array("SELECT gm_photoname FROM gm_stuinfo WHERE gm_num='{$_GET['num']}' LIMIT 1");
			$photoname="photos".$r_s['gm_photoname'];
			chmod($photoname,0777);  
			unlink($photoname);	
			_query("DELETE FROM gm_stuinfo WHERE gm_num='{$_GET['num']}'");
			_location('删除成功！', 'stu_active.php');
		}else{
			_location('删除失败！', 'stu_active.php');
		}
		}
	}
	else{
		_alert_back('要操作的学号不存在！');
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
 <script type="text/javascript" src="js/sortable-table.js"></script>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header_admin.inc.php';
?>
<div id="main">
<?php 
//判断是否有需要审核的学生
if($num==0){
		echo "<span class='ex'>暂时没有学生信息需要审核</span>";
	}else{
?>
<table class="sortableTable">
	<thead>
	<tr>
		<th class="sortableCol"  valuetype="number">序号</th>
		<th class="sortableCol">姓名</th>
		<th class="sortableCol"  valuetype="number">学号</th>
		<th class="sortableCol">性别</th>
		<th class="sortableCol">年级</th>
		<th class="sortableCol">专业</th>
		<th class="sortableCol">培养类型</th>
		<th>审核</th>
	</tr>
	</thead>
	<tbody>
	<?php 
	for($i=1;$i<=$pagesize;$i++){
		$rows=_fetch_array_list($res);
		if($rows['gm_num']=='')break;
		echo "<tr><td>$i</td><td>{$rows['gm_username']}</td><td>{$rows['gm_num']}</td><td>{$rows['gm_sex']}</td><td>{$rows['gm_grade']}</td><td>{$rows['gm_subject']}</td><td>{$rows['gm_type']}</td><td><a href='stu_date_one.php?num={$rows['gm_num']}'>详情</a> <a href='###' onclick=_confirm('确定审核通过吗？','stu_active.php?action=pass&num={$rows['gm_num']}')>通过</a> <a href='###' onclick=_confirm('确定删除吗？','stu_active.php?action=del&num={$rows['gm_num']}')>删除</a></td></tr>";
	}	
	?>
	</tbody>
</table>

<?php  
//引入分页
_paging($_system['stu_active_page']); 
echo "<p class='record'>共有<span>$num</span>位用户需要审核</p>";
}
?>

</div>
<?php 
	require ROOT_PATH.'includes/footer_admin.inc.php';
?>
</body>
</html>