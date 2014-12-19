<?php
/**
*2012-8-19   By:NaV!
*/
//防止恶意调用
define('IN_GM',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','funds_add_admin');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
////引入资金专用函数库
//require dirname(__FILE__).'/includes/funds.func.php';
$action=$_GET['action'];
if($action=="one")
{
	echo '<form name="form2" method="post" action="action.php?action=oneAdd">';
	echo '工　号：<input class="text" id="inputNum" type="text" name="num" />(快速选择:<select name="num" onchange=getElementById("inputNum").value=this.value><option value="">点击选择</option>';
	$res=_query("SELECT gm_num,gm_username FROM gm_teacher ORDER BY gm_num");
	$num=_num_rows_list($res);
	for($i=0;$i<$num;$i++){
		$row=_fetch_array_list($res);
		echo '<option value='.$row['gm_num'].'>'.$row['gm_username'].'('.$row['gm_num'].')</option>';
	}
	echo '</select>)';
	echo '<br><select calss="select" name="type"><option value="-1">减</option><option value="1">加</option></select>';
	echo '金额：<input class="text money" type="text" name="money" value="1000"/>';
	echo '<br>摘要:<br><textarea class="textarea" name="details">论文版面费</textarea>';
	echo '<br><input class="button" id="submit" type="submit" value="提 交" />';
	echo '</form>';
}
if($action=="details"){
	$nums=$_GET['nums'];
		if(is_numeric($nums) AND _num_rows("SELECT gm_num FROM gm_teacher WHERE gm_num='$nums'")){
			$rows=_fetch_array("SELECT * FROM  gm_teacher WHERE gm_num='$nums'");
			echo '姓名:'.$rows['gm_username'];
			echo '　｜　工号:'.$rows['gm_num'];
			echo '　｜　剩余经费:'.$rows['gm_funds'];
			$stu=explode(',', $rows['gm_student']);
			$stu_count=count($stu);
			if($stu[0]=='')
				$stu_count=0;
			echo '　｜　学生数:'.$stu_count;
		}else{
			echo "<b>没找到该位导师的信息！</b>";
		}
}
if($action=="oneAdd"){
	$num=trim($_POST['num']);
	$type=trim($_POST['type']);
	$money=trim($_POST['money']);
	if(!is_numeric($num) || !is_numeric($money)){
		_alert_back("工号或金额必须是数字！");
	}
	if($type<0)	$money=-$money;
	$details=trim($_POST['details']);
	if(!$num OR !$type OR !$money OR !$details)
		_alert_back("信息填写不完整！");	
	$row_t=_fetch_array("SELECT gm_funds FROM gm_teacher WHERE gm_num='$num'");
	if(($row_t['gm_funds']+$money)<0)
	 	_alert_back("导师剩余经费不足，操作失败！");
	$lmoney=$row_t['gm_funds']+$money;
	if(_query("UPDATE gm_teacher SET gm_funds=gm_funds+'$money' WHERE gm_num='$num'")
	and _query("INSERT INTO gm_funds(gm_ftype,gm_num,gm_time,gm_money,gm_lmoney,gm_details) VALUES('1','$num',NOW(),'$money','$lmoney','$details')")){
		_alert_back("操作成功！");	
	}else{
		_alert_back("操作失败！");
	}
}
if($action=="two"){
	require ROOT_PATH.'includes/details_two.inc.php';
}
if($action=="twoAdd"){
	$get=str_replace("\\","",$_GET['get']);
	if($get!=""){
		$sql="SELECT * FROM gm_stuinfo WHERE $get AND gm_active='1'";
	}else{
		$sql="SELECT * FROM gm_stuinfo WHERE gm_active='1'";
	}	
	if($num=_num_rows($sql)){
		$res=_query($sql);
		for($i=0;$i<$num;$i++){
			$row=_fetch_array_list($res);
			echo "<span>{$row['gm_num']}</span>";
		}
		echo "#";
		echo '<form name="form3" id="form3" method="post" action="">';
		echo '<br><select calss="select" name="type"><option value="-1">减</option><option value="1">加</option></select>';
		echo '金额：<input class="text" type="text" name="money" />';
		echo '<br>摘要:<br><textarea class="textarea" name="details" ></textarea>';
		echo '<br><input class="button" id="submit3" type="submit" value="提 交" />';
		echo '</form>';
		echo "符合条件的共有 ".$num." 位同学！已选择： <span id='selectedspan' style='color:red'>".$num."</span> 位";
	}else{
		echo "没有符合条件的学生！";
		//这里也要输出一个#!!
		echo "#";
	}


}
if($action=="twoAddEnd"){
	$nums=$_GET['nums'];
	$type=$_GET['type'];
	$money=$_GET['money'];
	$details=$_GET['details'];
	$nums=explode(",",$nums); 
	if(!is_numeric($money)){
		echo "数目必须是数字!";
	}else {
	if($type<0)$money=-$money;
	for($i=0;$i<count($nums);$i++){	
		$row_s=_fetch_array("SELECT gm_teacher FROM gm_stuinfo WHERE gm_num='{$nums["$i"]}'");
		if($row_s['gm_teacher']==NULL or $row_s['gm_teacher']==''){
			echo "<font color=red>".$nums[$i]."因未分配导师，操作失败！</font><br />";
		}else{
		$row_t=_fetch_array("SELECT * FROM gm_teacher WHERE gm_username='{$row_s['gm_teacher']}'");
		if(($row_t['gm_funds']+$money)<0){
	 		echo "<font color=red>".$nums["$i"]."因导师剩余经费不足，操作失败！</font><br />";
	 		continue;
		}
		$lmoney=$row_t['gm_funds']+$money;
		if(_query("UPDATE gm_teacher SET gm_funds=gm_funds+'$money' WHERE gm_num='{$row_t['gm_num']}'")
		and _query("INSERT INTO gm_funds(gm_ftype,gm_num,gm_time,gm_money,gm_lmoney,gm_details) VALUES('2','{$row_t['gm_num']}',NOW(),'$money','$lmoney','$details')") or die(mysql_error())){
			echo $nums["$i"]."成功！<br />";
		}else{
			echo "<font color=red>".$nums[$i]."失败！</font><br />";
		}
		}
	}
	}
}
if($action=="sysset"){
	echo '<dl>';
	echo '<form action="action.php?action=saveset" method="post">';
	echo '<dd>网站标题：<input class="text" type="text" name="webname" value="'.$_system['webname'].'" /></dd>';
	echo '<dd>初始密码：<input class="text" type="text" name="initial_password" value="'.$_system['initial_password'].'" /></dd>';
	$flag=$_system['register']==0?"selected='selected'":"";		
	echo '<dd>是否允许注册：<select name="register"><option value="1">允许</option><option value="0" '.$flag.'>禁止</option></select></dd>';
	$flag=$_system['needcode']==0?"selected='selected'":"";
	echo '<dd>是否开启验证码：<select name="needcode"><option value="1">开启</option><option value="0" '.$flag.'>关闭</option></select></dd>';
	echo '<dd>登陆界面的提示信息：<input class="text_l" type="text" name="help_login" value="'.$_system['help_login'].'" /><br/>(换行用<ｂr/>)</dd>';
	echo '<dd><input class="submit" type="submit" value="保存修改" /></dd>';
	echo '</form>';
	echo '</dl>';
	
}
if($action=="saveset"){
	if($_POST['webname'] && $_POST['initial_password']){
		if(_query("UPDATE gm_system SET gm_webname='{$_POST['webname']}',gm_initial_password='{$_POST['initial_password']}',gm_register='{$_POST['register']}',gm_needcode='{$_POST['needcode']}',gm_help_login='{$_POST['help_login']}' WHERE gm_id=1 LIMIT 1")){
			_alert_back("修改成功！");
		}else{
			_alert_back("修改失败！");
		}			
	}else{
		_alert_back("网站标题或默认密码不可为空！");
	}	
}

if($action=="page"){
	echo '<dl>';
	echo '<form action="action.php?action=savepage" method="post">';
	$flag=$_system['user_date_page']==2?"selected='selected'":"";	
	echo '<dd>用户信息：<select name="user_date_page"><option value="1">数字型</option><option value="2" '.$flag.'>文本型</option></select> 每页<input class="pagesize" type="text" name="user_date_pagesize" value="'.$_system['user_date_pagesize'].'"/>条</dd>';
	$flag=$_system['stu_active_page']==2?"selected='selected'":"";	
	echo '<dd>审核页面：<select name="stu_active_page"><option value="1">数字型</option><option value="2" '.$flag.'>文本型</option></select> 每页<input class="pagesize" type="text" name="stu_active_pagesize" value="'.$_system['stu_active_pagesize'].'"/>条</dd>';
	$flag=$_system['stu_date_page']==2?"selected='selected'":"";	
	echo '<dd>研究生/导师信息：<select name="stu_date_page"><option value="1">数字型</option><option value="2" '.$flag.'>文本型</option></select> 每页<input class="pagesize" type="text" name="stu_date_pagesize" value="'.$_system['stu_date_pagesize'].'"/>条</dd>';
	$flag=$_system['message_page']==2?"selected='selected'":"";	
	echo '<dd>留言板：<select name="message_page"><option value="1">数字型</option><option value="2" '.$flag.'>文本型</option></select> 每页<input class="pagesize" type="text" name="message_pagesize" value="'.$_system['message_pagesize'].'"/>条</dd>';
	$flag=$_system['notice_page']==2?"selected='selected'":"";	
	echo '<dd>公告中心：<select name="notice_page"><option value="1">数字型</option><option value="2" '.$flag.'>文本型</option></select> 每页<input class="pagesize" type="text" name="notice_pagesize" value="'.$_system['notice_pagesize'].'"/>条</dd>';
	$flag=$_system['funds_admin_page']==2?"selected='selected'":"";	
	echo '<dd>经费管理：<select name="funds_admin_page"><option value="1">数字型</option><option value="2" '.$flag.'>文本型</option></select> 每页<input class="pagesize" type="text" name="funds_admin_pagesize" value="'.$_system['funds_admin_pagesize'].'"/>条</dd>';
	echo '<dd><input class="submit" type="submit" value="保存修改" /></dd>';
	echo '</form>';
	echo '</dl>';
}

if($action=="savepage"){
	if($_POST['user_date_pagesize'] && $_POST['stu_active_pagesize'] && $_POST['stu_date_pagesize'] && $_POST['message_pagesize'] && $_POST['notice_pagesize'] && $_POST['funds_admin_pagesize']){
	if(_query("UPDATE gm_system SET
										gm_user_date_page='{$_POST['user_date_page']}',
										gm_stu_active_page='{$_POST['stu_active_page']}',
										gm_stu_date_page='{$_POST['stu_date_page']}',
										gm_message_page='{$_POST['message_page']}',
										gm_notice_page='{$_POST['notice_page']}',
										gm_funds_admin_page='{$_POST['funds_admin_page']}',
										gm_user_date_pagesize='{$_POST['user_date_pagesize']}',
										gm_stu_active_pagesize='{$_POST['stu_active_pagesize']}',
										gm_stu_date_pagesize='{$_POST['stu_date_pagesize']}',
										gm_message_pagesize='{$_POST['message_pagesize']}',
										gm_notice_pagesize='{$_POST['notice_pagesize']}',
										gm_funds_admin_pagesize='{$_POST['funds_admin_pagesize']}'
								WHERE gm_id=1
								LIMIT 1")){
			_alert_back("修改成功！");
		}else{
			_alert_back("修改失败！");
		}
	}else{
		_alert_back("分页大小不可为空！");
	}
}










?>