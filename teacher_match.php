<?php
/**
*2012-9-12   By:NaV!
*/
//防止恶意调用
define('IN_GM',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','teacher_match');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
$action=$_GET['action'];


//查看所有未分配的
if($action=='some' or $action=='all'){
if($action=='some')
	$res=_query("SELECT * FROM gm_stuinfo WHERE (gm_teacher is null OR gm_teacher='') AND gm_active='1' ORDER BY gm_num");
if($action=='all')	
	$res=_query("SELECT * FROM gm_stuinfo WHERE gm_active='1' ORDER BY gm_teacher");
$nums=_num_rows_list($res);
}


//分配单个
if($action=='one'){
	$res=_query("SELECT gm_username,gm_student FROM gm_teacher");
	$nums=_num_rows_list($res);
if($_POST['submit']=="提 交"){
	if(is_numeric($_POST['num'])){
		$r=_fetch_array("SELECT gm_student FROM gm_teacher WHERE gm_username='{$_POST['teacher']}' LIMIT 1");
		$r_s=_fetch_array("SELECT gm_num,gm_teacher,gm_active FROM gm_stuinfo WHERE gm_num='{$_POST['num']}' LIMIT 1");
		if($r_s['gm_active']==0)
			_location("该生未通过审核，分配失败！","teacher_match.php?action=one");
		//判断是否已经分配过了
		if($_POST['teacher']==$r_s['gm_teacher']){
			_location("该生已经分配了这位导师！","teacher_match.php?action=one");
		}
		//对导师的学生字段重新组合
		if($r['gm_student'])
			$student=$r['gm_student'].",".$_POST['num'];
		else 
			$student=$_POST['num'];
			
		if(_query("UPDATE gm_stuinfo SET gm_teacher='{$_POST['teacher']}' WHERE gm_num='{$_POST['num']}' LIMIT 1") and _query("UPDATE gm_teacher SET gm_student='$student' WHERE gm_username='{$_POST['teacher']}' LIMIT 1")){
			//删除辅导这位学生的老师那边的信息
			if($r_s['gm_teacher']){
			$r_t=_fetch_array("SELECT gm_student FROM gm_teacher WHERE gm_username='{$r_s['gm_teacher']}' LIMIT 1");
			$students=explode(",",$r_t['gm_student']);
			$students_e="";
			//通过循环过滤删除
			for($i=0;$i<count($students);$i++){
				if($students[$i]!=$_POST['num']){
					if($students_e!="")
						$students_e=$students_e.",".$students[$i];
					else 
						$students_e=$students[$i];
				}
			}
			if(!_query("UPDATE gm_teacher SET gm_student='$students_e' WHERE gm_username='{$r_s['gm_teacher']}' LIMIT 1"))
				_location("分配失败！", "teacher_match.php?action=one");
			}
			_location("分配成功！", "teacher_match.php?action=one");
		}
	}else{
		_location("填写不正确！","teacher_match.php?action=one");
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
 <script type="text/javascript" src="js/sortable-table.js"></script>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header_admin.inc.php';
?>
<div id="main">

 <div id="main_in">
 <?php if($action=='some' or $action=='all'){	
 	if($action=='some')
 		echo '<p>查看：<span class="type one" onclick=location.href="teacher_match.php?action=some">未分配</span><span class="type" onclick=location.href="teacher_match.php?action=all">全部</span><span class="type" onclick=location.href="teacher_match.php?action=one">个人</span></p>';
 	else 
 		echo '<p>查看：<span class="type" onclick=location.href="teacher_match.php?action=some">未分配</span><span class="type one" onclick=location.href="teacher_match.php?action=all">全部</span><span class="type" onclick=location.href="teacher_match.php?action=one">个人</span></p>';	
?>
 <table class="sortableTable">
		<thead>
			<tr>
				<th class="sortableCol" valuetype="number">序号</th>
				<th class="sortableCol">姓名</th>
				<th class="sortableCol" valuetype="number">学号</th>
				<th class="sortableCol">性别</th>
				<th class="sortableCol">年级</th>
				<th class="sortableCol">专业</th>
				<th class="sortableCol">培养类型</th>
				<th class="sortableCol">导师</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		for($i=1;$i<=$nums;$i++){
			$row=_fetch_array_list($res);
			if($row['gm_num']=='')
				break;
			if($row['gm_teacher']==''){
				$zt="<font color=red>未分配</font>";
				$cz="分配";
			}
			else{
				$zt=$row['gm_teacher'];	
				$cz="重新分配";
			}
			echo "<tr><td>$i</td><td>{$row['gm_username']}</td><td>{$row['gm_num']}</td><td>{$row['gm_sex']}</td><td>{$row['gm_grade']}</td><td>{$row['gm_subject']}</td><td>{$row['gm_type']}</td><td>$zt</td><td><a href='stu_date_one.php?num={$row['gm_num']}'>详细</a> <a href='teacher_match.php?action=one&num={$row['gm_num']}'>$cz</a>";
			echo "</td></tr>";
		}	
		?>
		</tbody>
	</table>
 
  <?php }elseif($action=='one'){?>
 <p>查看：<span class="type" onclick="location.href='teacher_match.php?action=some'">未分配</span><span class="type" onclick="location.href='teacher_match.php?action=all'">全部</span><span class="type one" onclick="location.href='teacher_match.php?action=one'">个人</span></p>
 <div id="main_in_in">
 <fieldset>
    <legend>分配导师</legend>
    <form method="post" action="teacher_match.php?action=one">
    学号：<input type="text" name="num" id="inputNum" value="<?php echo $_GET['num']; ?>" /><br />
    (快速选择：<select name="num_s" onchange="getElementById('inputNum').value=this.value"><option value="">-请选择-</option>
	<?php 
	$res_s=_query("SELECT gm_num FROM gm_stuinfo WHERE gm_active='1' AND gm_active='1' ORDER BY gm_num");
	$num_s=_num_rows_list($res_s);
	for($i=0;$i<$num_s;$i++){
		$row=_fetch_array_list($res_s);
		echo '<option value='.$row['gm_num'].'>'.$row['gm_num'].'</option>';
	}
	?>  
	</select>)<br />
    分配导师：<select name="teacher">
			<?php 
			echo '<option value="">-无-</option>';
			for($i=0;$i<$nums;$i++){
				$rows=_fetch_array_list($res);
				echo '<option>'.$rows['gm_username'].'</option>';
			}
			?>
		</select><br />
   	<input type="submit" value="提 交" name="submit" class="submit"/>
    </form>
 </fieldset>   
</div>  
  
  <?php }?>
 </div>
</div>
<?php 
	require ROOT_PATH.'includes/footer_admin.inc.php';
?>
</body>
</html>