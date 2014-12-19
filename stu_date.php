<?php
/**
*2012-8-2 |  By:NaV!
*/
//防止恶意调用
define('IN_GM',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','stu_date');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
//判断登录状态和权限
_login_state(2);
if($_GET['action']==''){
$num = _num_rows("SELECT * FROM gm_stuinfo WHERE gm_active='1'");
//分页模块
_page($num,$_system['stu_date_pagesize']);
$res = _query("SELECT * FROM gm_stuinfo WHERE gm_active='1' ORDER BY gm_num LIMIT $pagenum,$pagesize");
}elseif($_GET['action']=='one' and $_POST['value']!=''){
	$type="gm_".$_POST['type'];
	$res=_query("SELECT * FROM gm_stuinfo WHERE gm_active='1' AND $type LIKE '%{$_POST['value']}%'");
	$pagesize=$num=_num_rows_list($res);
}
if($_GET['action']=="del" && $_GET['num']){
$r_s=_fetch_array("SELECT gm_num,gm_teacher,gm_photoname FROM gm_stuinfo WHERE gm_num='{$_GET['num']}' LIMIT 1");
	$num_s=_num_rows("SELECT gm_num,gm_teacher FROM gm_stuinfo WHERE gm_num='{$_GET['num']}' LIMIT 1");
	if($num_s){
		if($r_s['gm_teacher']){
				$r_t=_fetch_array("SELECT gm_student FROM gm_teacher WHERE gm_username='{$r_s['gm_teacher']}' LIMIT 1");
				$students=explode(",",$r_t['gm_student']);
				$students_e="";
				//通过循环过滤删除
				for($i=0;$i<count($students);$i++){
					if($students[$i]!=$_GET['num']){
						if($students_e!="")
							$students_e=$students_e.",".$students[$i];
						else 
							$students_e=$students[$i];
					}
				}
				if(!_query("UPDATE gm_teacher SET gm_student='$students_e' WHERE gm_username='{$r_s['gm_teacher']}' LIMIT 1"))
					_location("更新导师信息表时出错！", "user_data.php");
		}	
	$photoname="photos".$r_s['gm_photoname'];
	chmod($photoname,0777);  
	unlink($photoname);	
	if(!_query("DELETE FROM gm_stuinfo WHERE gm_num='{$_GET['num']}'") or !_query("DELETE FROM gm_user WHERE gm_num='{$_GET['num']}'"))
		_location('从学生表或用户表中删除数据时失败！！', 'user_data.php');
	_location('删除成功！', 'user_data.php');
	}else{
		_location('未找到你要删除的数据！', 'user_data.php');
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
//搜索，公用的
	echo "<div id='search'><form action='stu_date.php?action=one' method='post'><select name='type'><option value='username'>姓名</option><option value='num'>学号</option><option value='sex'>性别</option><option value='grade'>年级</option><option value='subject'>专业</option><option value='type'>培养类型</option></select><input type='text' name='value' class='search' /> <input type='image' src='images/search.gif' alt='搜索' class='img'/></form></div>";
?>
	<table class="sortableTable">
		<thead>
			<tr>
				<th class="sortableCol" valuetype="number">序号</th>
				<th class="sortableCol">姓名</th>
				<th class="sortableCol" valuetype="number">学号</th>
				<th class="sortableCol">导师</th>
				<th class="sortableCol">性别</th>
				<th class="sortableCol">年级</th>				
				<th class="sortableCol">专业</th>
				<th class="sortableCol">培养类型</th>
				<th class="sortableCol">家庭住址</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		for($i=1;$i<=$pagesize;$i++){
			$row=_fetch_array_list($res);
			$address=_cut($row['gm_address'],15);
			if(!$row['gm_teacher'])
				$row['gm_teacher']='<a href="teacher_match.php?action=one&num='.$row['gm_num'].'">分配</a>';
			if($row['gm_num']=='')
				break;
			echo "<tr><td>$i</td><td>{$row['gm_username']}</td><td>{$row['gm_num']}</td><td>{$row['gm_teacher']}</td><td>{$row['gm_sex']}</td><td>{$row['gm_grade']}</td><td>{$row['gm_subject']}</td><td>{$row['gm_type']}</td><td title='{$row['gm_address']}'>$address</td><td><a href='stu_date_one.php?num={$row['gm_num']}'>详细</a> <a href='stu_data_edit.php?num={$row['gm_num']}'>修改</a>";
			if($_SESSION['level']==3)
				echo " <a href='###' onclick=_confirm('确定删除该同学资料吗？','stu_date.php?action=del&num={$row['gm_num']}')>删除</a>";
			echo "</td></tr>";
		}	
		?>
		</tbody>
	</table>
<?php 
//引入分页
if($_GET['action']=='')
	_paging($_system['stu_date_page']);
?>
</div>
<?php 
	require ROOT_PATH.'includes/footer_admin.inc.php';
?>
</body>
</html>