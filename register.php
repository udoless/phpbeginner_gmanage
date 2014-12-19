<?php
/**
*2012-7-28  |  By:NaV!
*/
//是否需要验证码
$needcode=1;
session_start();
//防止恶意调用
define('IN_GM',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','register');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
//判断是否允许注册
if(!$_system['register']){
	_alert_back("现在不是注册时间！");
}
//开始处理提交内容
if($_GET['action']==register){
	include ROOT_PATH.'includes/register.func.php';
	if($_system['needcode']==1){
		_check_code($_SESSION['code'], $_POST['code']);
	}
	$clean=array();
	$clean['username']=_check_username($_POST['username']);
	$clean['num']=_check_num($_POST['num']);
	$clean['sex']=_check_sex($_POST['sex']);
	_checkdate($_POST['birth_m'], $_POST['birth_d'], $_POST['birth_y']);
	_checkdate($_POST['start_time_m'], $_POST['start_time_d'], $_POST['start_time_y']);
	$clean['birth']=$_POST['birth_y'].'-'.$_POST['birth_m'].'-'.$_POST['birth_d'];
	$clean['start_time']=$_POST['start_time_y'].'-'.$_POST['start_time_m'].'-'.$_POST['start_time_d'];
	$clean['gm_grade']=_time_to_grade($_POST['start_time_y'],$_POST['start_time_m']);
	$clean['contact']=_check_contact($_POST['contact']);
	$clean['address']=_check_address_ex($_POST['address']);
	$clean['subject']=_check_subject($_POST['subject']);
	$clean['type']=_check_type($_POST['type']);	
	$clean['photoname']=_check_photo();
	//判断是否已经注册
	_is_repeat("SELECT gm_num FROM gm_user WHERE gm_num = '{$clean['num']}'",'该学号已经被注册！如有问题请咨询管理员！');
	$newpassword=_check_password($_system['initial_password']);
	if(_query("INSERT INTO gm_user(
									gm_username,
									gm_num,
									gm_password,
									gm_reg_time,
									gm_last_time,
									gm_last_ip) 
								VALUES(
									'{$clean['username']}',
									'{$clean['num']}',
									'$newpassword',
									NOW(),
									NOW(),
									'{$_SERVER["REMOTE_ADDR"]}')")
	and _query("INSERT INTO gm_stuinfo(
									gm_username,
									gm_num,
									gm_sex,
									gm_birth,
									gm_start_time,
									gm_grade,
									gm_contact,
									gm_address,
									gm_subject,
									gm_type,
									gm_photoname) 
								VALUES(
									'{$clean['username']}',
									'{$clean['num']}',
									'{$clean['sex']}',
									'{$clean['birth']}',
									'{$clean['start_time']}',
									'{$clean['gm_grade']}',
									'{$clean['contact']}',
									'{$clean['address']}',
									'{$clean['subject']}',
									'{$clean['type']}',
									'{$clean['photoname']}')")){
		_location('你的信息已经提交，请耐心等待审核！', 'login.php');
	}else{
		_alert_back('注册失败！有问题请咨询管理员！');
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>计算机学院研究生档案管理--注册</title>

<link rel="stylesheet" type="text/css" href="styles/basic.css" />
<link rel="stylesheet" type="text/css" href="styles/register.css" />

<script type="text/javascript" src="js/code.js"></script>
<script type="text/javascript" src="js/register.js"></script>
<script type="text/javascript" src="js/areaBase.js"></script>
<script type="text/javascript" src="js/area.js"></script>
</head>
<body>
<div id="outmain">
<div id="main">
	<img src="images/loginlogo.png" alt="计算机学院" />
	<h2>请认真填写以下内容&gt;&gt;&gt;</h2>
	<form action="register.php?action=register" method="post" name="register" enctype="multipart/form-data" >
		<dl>
			<dt></dt>
			<dd>姓　　名：<input type="text" name="username" class="text"/></dd>
			<dd>学　　号：<input type="text" name="num" class="text"/></dd>
			<dd>性　　别：<input type="radio" name="sex" class="radio" value="男" checked="checked"/> 男<input type="radio" name="sex" class="radio" value="女"/> 女</dd>
			<dd>出生年月：<select name="birth_y"><?php for($i=1980;$i<=1995;$i++)echo "<option value=$i>$i</option>";?></select>年<select name="birth_m"><?php for($i=1;$i<=12;$i++)echo "<option value=$i>$i</option>";?></select>月<select name="birth_d"><?php for($i=1;$i<=31;$i++)echo "<option value=$i>$i</option>";?>
</select>日</dd>
			<dd>入学时间：<select name="start_time_y"><?php for($i=2000;$i<=2012;$i++)echo "<option value=$i>$i</option>";?></select>年<select name="start_time_m"><?php for($i=1;$i<=12;$i++)echo "<option value=$i>$i</option>";?></select>月<select name="start_time_d"><?php for($i=1;$i<=31;$i++)echo "<option value=$i>$i</option>";?>
</select>日</dd>
			<dd>手机号码：<input type="text" name="contact" class="text"/></dd>
			<dd>家庭住址：<input type="text" name="address" class="text"/></dd>
			<dd>专　　业：<select name="subject"><option value="计算机应用技术" selected="selected">计算机应用技术</option><option value="计算机软件与理论">计算机软件与理论</option><option value="计算机技术">计算机技术</option><option value="计算机科学与技术">计算机科学与技术</option>
</select></dd>
			<dd>培养管理类型：<select name="type"><option value="学术型" selected="selected">学术型</option><option value="专业型">专业型</option><option value="工程型">工程型</option></select></dd>
			<dd>照　　片：<input type="file" name="photo" class="text"/></dd>
			<?php if($_system['needcode']==1){echo "<dd>验 证 码： <input type='text' name='code' class='text code' /> <img src='code.php' id='code' /></dd>";}?>
			<dd><input type="submit" name="submit" class="button" value="提 交"/><input type="reset" name="reset" class="button" value="重 置"/><input class="button"  onclick="history.back()"  value="　返 回"/></dd>		
		</dl>	
	</form>
</div>
</div>
</body>
</html>