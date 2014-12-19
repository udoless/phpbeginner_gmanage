<?php
/**
*2012-8-21   By:NaV!
*/
//防止恶意调用
define('IN_GM',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','stu_data_edit');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
//判断登录状态和权限
_login_state(2);
if($_GET['num']!=""){
$row=_fetch_array("SELECT * FROM gm_stuinfo WHERE gm_num={$_GET['num']}");
	$birth=explode("-",$row['gm_birth']);
	$start=explode("-",$row['gm_start_time']);

	$res_t=_query("SELECT gm_username FROM gm_teacher");
	$nums_t=_num_rows_list($res_t);
}
//开始处理提交内容
if($_POST['submit']=="提 交"){
	include ROOT_PATH.'includes/register.func.php';
	if($_system['needcode']==1){
		_check_code($_SESSION['code'], $_POST['code']);
	}
	$clean=array();
	$clean['username']=_check_username($_POST['username']);
	$clean['teacher']=$_POST['teacher'];
	$clean['sex']=_check_sex($_POST['sex']);
	_checkdate($_POST['birth_m'], $_POST['birth_d'], $_POST['birth_y']);
	_checkdate($_POST['start_time_m'], $_POST['start_time_d'], $_POST['start_time_y']);
	$clean['birth']=$_POST['birth_y'].'-'.$_POST['birth_m'].'-'.$_POST['birth_d'];
	$clean['start_time']=$_POST['start_time_y'].'-'.$_POST['start_time_m'].'-'.$_POST['start_time_d'];
	$clean['gm_grade']=_time_to_grade($_POST['start_time_y'],$_POST['start_time_m']);
	$clean['contact']=_check_contact($_POST['contact']);	 
	$clean['address']=$_POST['address'];
	$clean['subject']=_check_subject($_POST['subject']);
	$clean['type']=_check_type($_POST['type']);	
	if($_FILES['photo']['size']!="0"){
		$clean['photoname']=_check_photo();
	}else{
		$clean['photoname']=$_POST['oldphotoname'];
	}
	
	

		$r=_fetch_array("SELECT gm_student FROM gm_teacher WHERE gm_username='{$_POST['teacher']}' LIMIT 1");
		$r_s=_fetch_array("SELECT gm_num,gm_teacher FROM gm_stuinfo WHERE gm_num='{$_POST['num']}' LIMIT 1");
		//对导师的学生字段重新组合
		if($r['gm_student']){
			if($_POST['teacher']!=$r_s['gm_teacher'])
				$student=$r['gm_student'].",".$_POST['num'];
			else 
				$student=$r['gm_student'];	
		}
		else{ 
			$student=$_POST['num'];
		}	
		if(_query("UPDATE gm_teacher SET gm_student='$student' WHERE gm_username='{$_POST['teacher']}' LIMIT 1")){
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
			_query("UPDATE gm_teacher SET gm_student='$students_e' WHERE gm_username='{$r_s['gm_teacher']}' LIMIT 1");
				
			}
		}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	if(_query("UPDATE gm_user SET gm_username='{$clean['username']}' WHERE gm_num='{$_POST['num']}'")
	and _query("UPDATE gm_stuinfo SET gm_username='{$clean['username']}',
				gm_teacher='{$clean['teacher']}',
				gm_sex='{$clean['sex']}',
				gm_birth='{$clean['birth']}',
				gm_start_time='{$clean['start_time']}',
				gm_grade='{$clean['gm_grade']}',
				gm_contact='{$clean['contact']}',
				gm_address='{$clean['address']}',
				gm_subject='{$clean['subject']}',
				gm_type='{$clean['type']}',
				gm_photoname='{$clean['photoname']}' WHERE gm_num='{$_POST['num']}'")){
	
		_alert_back_back('修改成功！');
	}else{
		_alert_back('修改失败！');
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
<script type="text/javascript" src="js/code.js"></script>
<script type="text/javascript" src="js/register.js"></script>
<script type="text/javascript" src="js/areaBase.js"></script>
<script type="text/javascript" src="js/area.js"></script>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header_admin.inc.php';
?>
<div id="main">
	<form action="stu_data_edit.php" method="post" enctype="multipart/form-data" >
	
		<dl>
			<dt>学生信息修改</dt>
			<dd>姓　　名：<input type="text" name="username" class="text" value="<?php echo $row['gm_username']?>"/></dd>
			<dd>学　　号：<input type="text" class="text" value="<?php echo $row['gm_num']?>" disabled="disabled"/>
						<input type="hidden" name="num" value="<?php echo $row['gm_num']?>" />
			</dd>
			<dd>导　　师：<select name="teacher">
			<?php 
			if($row['gm_active']==0)
				echo '<option value="">未审核无法分配</option>';
			else{
				echo '<option value="">无</option>';
				for($i=0;$i<$nums_t;$i++){
					$rows_t=_fetch_array_list($res_t);
					if($row['gm_teacher']==$rows_t['gm_username'])
						echo '<option selected="selected">'.$rows_t['gm_username'].'</option>';
					else 
						echo '<option>'.$rows_t['gm_username'].'</option>';
				}
			}
			?></select></dd>
			<dd>性　　别：<input type="radio" name="sex" class="radio" value="男" <?php if($row['gm_sex']=='男')echo "checked='checked'"?>/> 男<input type="radio" name="sex" class="radio" value="女" <?php if($row['gm_sex']=='女')echo "checked='checked'"?>/> 女</dd>
			<dd>出生年月：<select name="birth_y"><?php for($i=1980;$i<=1995;$i++){if($birth[0]==$i)echo "<option value=$i selected='selected'>$i</option>";else echo "<option value=$i>$i</option>";}?></select>年<select name="birth_m"><?php for($i=1;$i<=12;$i++){if($birth[1]==$i)echo "<option value=$i selected='selected'>$i</option>";else echo "<option value=$i>$i</option>";}?></select>月<select name="birth_d"><?php for($i=1;$i<=31;$i++){if($birth[2]==$i)echo "<option value=$i selected='selected'>$i</option>";else echo "<option value=$i>$i</option>";}?>
</select>日</dd>
			<dd>入学时间：<select name="start_time_y"><?php for($i=2000;$i<=2012;$i++){if($start[0]==$i)echo "<option value=$i selected='selected'>$i</option>";else echo "<option value=$i>$i</option>";}?></select>年<select name="start_time_m"><?php for($i=1;$i<=12;$i++){if($start[1]==$i)echo "<option value=$i selected='selected'>$i</option>";else echo "<option value=$i>$i</option>";}?></select>月<select name="start_time_d"><?php for($i=1;$i<=31;$i++){if($start[2]==$i)echo "<option value=$i selected='selected'>$i</option>";else echo "<option value=$i>$i</option>";}?>
</select>日</dd>
			<dd>联系方式：<input type="text" name="contact" class="text" value="<?php echo $row['gm_contact']?>"/></dd>
			<dd>家庭住址：<input type="text" name="address" class="text" value="<?php echo $row['gm_address']?>" /></dd>		
			<dd>专　　业：<select name="subject"><option value="计算机应用技术" selected="selected">计算机应用技术</option><option value="计算机软件与理论" <?php if($row['gm_subject']=="计算机软件与理论")echo "selected='selected'"; ?>>计算机软件与理论</option><option value="计算机技术
" <?php if($row['gm_subject']=="计算机技术")echo "selected='selected'"; ?>>计算机技术</option>
</select></dd>
			<dd>培养管理类型：<select name="type"><option value="学术型" selected="selected">学术型</option><option value="专业型" <?php if($row['gm_type']=="专业型")echo "selected='selected'"; ?>>专业型</option><option value="工程型" <?php if($row['gm_type']=="工程型")echo "selected='selected'"; ?>>工程型</option></select></dd>
			<dd>照　　片：<input type="file" name="photo" class="text"/>
			<input type="hidden" name="oldphotoname" value="<?php echo $row['gm_photoname']?>" />
			</dd>
			<?php if($_system['needcode']==1){echo "<dd>验 证 码： <input type='text' name='code' class='text code' /> <img src='code.php' id='code' /></dd>";}?>
			<dd><input type="submit" name="submit" class="button" value="提 交"/><input type="button" value="返 回" class="button" onclick="history.back()" /></dd>		
		</dl>	
	</form>
</div>
<?php 
	require ROOT_PATH.'includes/footer_admin.inc.php';
?>
</body>
</html>