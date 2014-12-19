<?php
/**
*2012-8-1  |  By:NaV!
*/
//防止恶意调用
define('IN_GM',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','user_data');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
//判断登录状态和权限
_login_state(2);
//查看全部用户
if($_GET['action']=='' ){
if($num=_num_rows("SELECT gm_active FROM gm_user WHERE gm_active='1'")){
	//分页模块
	_page($num,$_system['user_date_pagesize']);
	$res=_query("SELECT * FROM gm_user WHERE gm_active='1' ORDER BY gm_level DESC,gm_num LIMIT $pagenum,$pagesize");
}
//查看个人
}elseif($_GET['action']=='one' and $_POST['num']!=''){
	$res=_query("SELECT * FROM gm_user WHERE gm_active='1' AND (gm_num LIKE '%{$_POST['num']}%' OR gm_username LIKE '%{$_POST['num']}%')");
	$pagesize=$num=_num_rows_list($res);
}
//添加管理员
if($_GET['action']=='addadmin'){
	//引入验证文件
	include ROOT_PATH.'includes/register.func.php';
	$clean=array();
	$clean['num']=_check_num($_POST['num']);
	$clean['password']=_check_password($_POST['password']);
	//判断是否已经注册
	_is_repeat("SELECT gm_num FROM gm_user WHERE gm_num = '{$clean['num']}'",'该帐号已经被注册！');
	if(_query("INSERT INTO gm_user(
									gm_active,
									gm_level,
									gm_username,
									gm_num,
									gm_password,
									gm_reg_time,
									gm_last_time,
									gm_last_ip) 
								VALUES(
									'1',
									'2',
									'admin',
									'{$clean['num']}',
									'{$clean['password']}',
									NOW(),
									NOW(),
									'{$_SERVER["REMOTE_ADDR"]}')")){
	$string="添加成功！\\n用户名:admin\\n登录帐号:{$clean['num']}\\n密码：{$_POST['password']}";
	_alert_back($string);								
	}else{
		_alert_back('添加失败！');
	}
}
//修改密码
if($_GET['action']=='pass_modify'){
	//引入验证文件
	include ROOT_PATH.'includes/register.func.php';
	$clean=array();
	$clean['password']=_check_password($_POST['password']);
	$clean['newpassword']=_check_password($_POST['newpassword']);
	//判断旧密码是否正确
	if(!_num_rows("SELECT gm_num FROM gm_user WHERE gm_active='1' AND gm_num = '{$_SESSION['num']}' AND gm_password = '{$clean['password']}'")){
		_alert_back('原密码不正确！');
	}
	if(_query("UPDATE gm_user SET gm_password = '{$clean['newpassword']}' WHERE gm_active='1' AND gm_num = '{$_SESSION['num']}'")){
	$string="密码修改成功！\\n用户名:{$_SESSION['username']}\\n登录帐号:{$_SESSION['num']}\\n密码：{$_POST['newpassword']}";
	_alert_back($string);		
}else{
	_alert_back('密码修改失败！');
}
}
//重置密码
if($_GET['action']=='password_reset'){
	//引入验证文件
	include ROOT_PATH.'includes/register.func.php';
	$newpassword = _check_password($_system['initial_password']);
	if($_GET['num']!='' and is_numeric($_GET['num'])){
		if(_query("UPDATE gm_user SET gm_password = '$newpassword' WHERE gm_num = '{$_GET['num']}'")){
			$string="密码重置成功！\\n新密码为：{$_system['initial_password']}";
			_location($string, 'user_data.php');	
		}else {
			_location('重置失败！','user_data.php');
		}
	}
	if($_GET['num']=='all'){
		$res=_query("SELECT gm_num,gm_password FROM gm_user WHERE gm_active='1'");
		$num1=_num_rows("SELECT gm_active FROM gm_user WHERE gm_active='1'");
		for($i=0;$i<$num1;$i++){
			$rows=_fetch_array_list($res);
			if(!_query("UPDATE gm_user SET gm_password = '$newpassword' WHERE gm_num = '{$rows['gm_num']}'")){
				_location('重置过程出现错误！','user_data.php');
			}
		}
		$string="密码重置成功！\\n新密码为：{$_system['initial_password']}";
		_location($string, 'user_data.php');
	}	
}
//删除
if($_GET['action']=="del" && $_GET['num']){
	$r_s=_fetch_array("SELECT gm_num,gm_teacher,gm_photoname FROM gm_stuinfo WHERE gm_num='{$_GET['num']}' LIMIT 1");
	$num_s=_num_rows("SELECT gm_num FROM gm_stuinfo WHERE gm_num='{$_GET['num']}' LIMIT 1");
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
	echo "<div id='search'><form action='user_data.php?action=one' method='post'>学号/工号/姓名：<input type='text' name='num' class='search' /> <input type='image' src='images/search.gif' alt='搜索' class='img'/></form></div>";
?>
	<table class="sortableTable">
		<thead>
			<tr>
				<th class="sortableCol"  valuetype="number">序号</th>
				<th class="sortableCol" >用户名</th>
				<th class="sortableCol"  valuetype="number">学号/工号</th>
				<th class="sortableCol" >注册时间</th>
				<th class="sortableCol">上次登录时间</th>
				<th class="sortableCol" >上次登录IP</th>
				<th class="sortableCol" >权限</th>
				<th>操作<?php if($_SESSION['level']==3)echo '(<a href="###" onclick=_confirm("确定重置所有用户密码吗？\n(这将重置所有用户密码!!并非搜索结果里的用户)","user_data.php?action=password_reset&num=all") >全部重置</a>)'; ?></th>
			</tr>
		</thead>
		<tbody>
		<?php 
		$sadmin=$admin=$common=0;
		for($i=1;$i<=$pagesize;$i++){
			$rows=_fetch_array_list($res);
			if($rows['gm_num']=='')
				break;
			switch ($rows['gm_level']){
				case 1:$common++;break;
				case 2:$admin++;break;
				case 3:$sadmin++;break;
			}
			$level=_level($rows['gm_level']);
			echo "<tr><td>$i</td><td>{$rows['gm_username']}</td><td>{$rows['gm_num']}</td><td>{$rows['gm_reg_time']}</td><td>{$rows['gm_last_time']}</td><td>{$rows['gm_last_ip']}</td><td>$level</td>";
			if($_SESSION['level']==2){
				if($rows['gm_level']==1)				
					echo "<td><a href='stu_date_one.php?num={$rows['gm_num']}'>详细</a> <a href='###' onclick=_confirm('确定重置该用户密码吗？','user_data.php?action=password_reset&num={$rows['gm_num']}')>重置密码</a></td>";
				else 
					echo "<td align='center'>/</td>";
			}elseif($_SESSION['level']==3){	
				if($rows['gm_level']==1)
					echo "<td><a href='stu_date_one.php?num={$rows['gm_num']}'>详细</a> <a href='###' onclick=_confirm('确定重置该用户密码吗？','user_data.php?action=password_reset&num={$rows['gm_num']}')>重置密码</a> <a href='###' onclick=_confirm('确定删除该同学资料吗？','user_data.php?action=del&num={$rows['gm_num']}')>删除</a></td>";
				elseif($_SESSION['username']==$rows['gm_username']) 
					echo "<td><a href='###' onclick=_confirm('确定重置该用户密码吗？','user_data.php?action=password_reset&num={$rows['gm_num']}')>重置密码</a></td>";
				else 	
					echo "<td><a href='###' onclick=_confirm('确定重置该用户密码吗？','user_data.php?action=password_reset&num={$rows['gm_num']}')>重置密码</a>  <a href='###' onclick=_confirm('确定删除该用户资料吗？','user_data.php?action=del&num={$rows['gm_num']}')>删除</a></td>";
			}
			echo "</tr>";
		}	
		?>
		</tbody>
	</table>
<?php 
//引入分页
if($_GET['action']=='')
_paging($_system['user_date_page']);
echo "<p class='record'>本页-超管:<span>$sadmin</span> 管理员:<span>$admin</span> 普通:<span>$common</span></p>";
 ?>
</div>
<?php 
	require ROOT_PATH.'includes/footer_admin.inc.php';
?>
</body>
</html>