<?php
/**
*2012-7-27  |  By:NaV!
*/
session_start();
//防止恶意调用
define('IN_GM',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','login');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
//开始处理登录信息
if($_GET['action']==login){
	include ROOT_PATH.'includes/register.func.php';
	if($_system['needcode']==1){
		_check_code($_SESSION['code'], $_POST['code']);
	}
	$clean=array();
	$clean['num']=_check_username($_POST['num']);
	$clean['password']=_check_password($_POST['password']);
	if($rows=_fetch_array("SELECT gm_num,gm_username,gm_active,gm_level FROM gm_user 
			WHERE 
			gm_num='{$clean['num']}' AND gm_password='{$clean['password']}' LIMIT 1")){
			if ($rows['gm_active']==0){
				_alert_back('您的资料正在被审核，请耐心等待！');
			}else {
				_query("UPDATE gm_user SET
										 gm_last_time=NOW(),
			 							 gm_last_ip='{$_SERVER["REMOTE_ADDR"]}' 
									 WHERE
			 							 gm_num='{$rows['gm_num']}'");
				//设置session
				$_SESSION['num']=$clean['num'];
				$_SESSION['username']=$rows['gm_username'];
				$_SESSION['level']=$rows['gm_level'];
				//判断权限分配页面
				if($_SESSION['level']==1){
					_location(null,'student_s.php');
				}else if ($_SESSION['level']==2 or $_SESSION['level']==3){
					_location(null,'admin.php');
				}else{
					_alert_back('非法操作！');
				}
				
			}
			}else{
				_alert_back('用户名或密码错误，忘记密码可请管理员重置');
			}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>计算机学院研究生档案管理--登录</title>
<link rel="stylesheet" type="text/css" href="styles/basic.css" />
<link rel="stylesheet" type="text/css" href="styles/login.css" />
<script type="text/javascript" src="js/code.js"></script>
<script type="text/javascript" src="js/login.js"></script>
</head>
<body>
<div id="login">
<h1><img src="images/loginlogo.png" alt="计算机学院" /></h1>
	<form name="login" method="post" action="login.php?action=login">	
		<dl>
			<dt></dt>
			<dd><label for="num">用户名：</label><input type="text" name="num" class="text" id="num"/></dd>
			<dd><label for="password"> 密　码：</label><input type="password" name="password" class="text" id="password"/></dd>
			<?php if($_system['needcode']==1){echo "<dd><label for='code1'>验证码：</label><input type='text' name='code' class='text code' id='code1' /> <img src='code.php' id='code' /></dd>";}?>
			<dd>　　<input type="submit" value="登 录" class="button" name="submit"/><input type="button" value="注 册" class="button" onclick="location.href='register.php'" /></dd>
		</dl>
	</form>
	<div>
<h3>*提示信息<span><?php echo $_system['help_login'];?></span></h3></div>
</div>

</body>
</html>