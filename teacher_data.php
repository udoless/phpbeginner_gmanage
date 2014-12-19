<?php
/**
*2012-9-13   By:NaV!
*/
//防止恶意调用
define('IN_GM',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','teacher_data');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
//判断登录状态和权限
_login_state(2);
if($_GET['action']==''){
$num = _num_rows("SELECT * FROM gm_teacher");
//分页模块
_page($num,$_system['stu_date_pagesize']);
$res = _query("SELECT * FROM gm_teacher ORDER BY gm_num LIMIT $pagenum,$pagesize");
}
//删除导师信息
if($_GET['action']=="del" && $_GET['num']){
		if(_num_rows("SELECT gm_student FROM gm_teacher WHERE gm_num='{$_GET['num']}'")){
			
			$res1=_query("SELECT gm_teacher,gm_num FROM gm_stuinfo");
			$nums1=_num_rows("SELECT gm_teacher FROM gm_stuinfo");
			$row_t=_fetch_array("SELECT gm_username FROM gm_teacher WHERE gm_num='{$_GET['num']}'");
			for($i=0;$i<$nums1;$i++){
				$row1=_fetch_array_list($res1);
				if($row1['gm_teacher']==$row_t['gm_username']){
					if(!_query("UPDATE gm_stuinfo SET gm_teacher='' WHERE gm_num='{$row1['gm_num']}'"))
						_alert_back("删除学生表中导师信息时出错！");
				}
			}
		}
		if(_query("DELETE FROM gm_teacher WHERE gm_num='{$_GET['num']}'")){
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
 <script type="text/javascript" src="js/sortable-table.js"></script>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header_admin.inc.php';
?>
<div id="main">
<table class="sortableTable">
		<thead>
			<tr>
				<th class="sortableCol" valuetype="number">序号</th>
				<th class="sortableCol">姓名</th>
				<th class="sortableCol" valuetype="number">工号</th>
				<th class="sortableCol">职称</th>
				<th class="sortableCol">剩余经费</th>
				<th class="sortableCol">学生数</th>
				<th class="sortableCol">学生姓名</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		for($i=1;$i<=$pagesize;$i++){
			$row=_fetch_array_list($res);
			$student="";
			$student_arr=explode(",",$row['gm_student']);
			if($student_arr[0]!=''){
			for($j=0;$j<count($student_arr);$j++){
				$rows=_fetch_array("SELECT gm_username,gm_num FROM gm_stuinfo WHERE gm_num='{$student_arr[$j]}'");
				//设置每行输出多少个学生，默认10个
				if(($j+1)%10==0)
					$student=$student." <a href=stu_date_one.php?num={$rows['gm_num']}>".$rows['gm_username']."</a><br />";
				else 
					$student=$student." <a href=stu_date_one.php?num={$rows['gm_num']}>".$rows['gm_username']."</a>";
			}
			}
			if(!$student){
				//count($student_arr)在没有学生的情况下还是1
				$student_arr=NULL;
				$student='无';
			}
			if($row['gm_num']=='')
				break;
			echo "<tr><td>$i</td><td>{$row['gm_username']}</td><td>{$row['gm_num']}</td><td>{$row['gm_zc']}</td><td>{$row['gm_funds']}</td><td>".count($student_arr)."</td><td>$student</td><td><a href='add_teacher.php?action=modify&num={$row['gm_num']}'>修改资料</a>";
			if($_SESSION['level']==3)
				echo " <a href='###' onclick=_confirm('确定删除该导师资料吗？','teacher_data.php?action=del&num={$row['gm_num']}')>删除</a>";
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