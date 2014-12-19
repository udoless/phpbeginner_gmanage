<?php
/**
*2012-7-28   By:NaV!
*/
/**
 * _login_state判断登录状态和权限
 * @param $level 当前页面所需要最低权限
 */

function _login_state($level){
	if(!$_SESSION['num'] || !$_SESSION['username']){
		_location("请先登录！","login.php");
	}
	if($level>$_SESSION['level']){
		_alert_back("权限不足！");
	}
}

/**
 * _alert_back  js弹窗提示，没有exit的话还会继续往下执行，小心、
 * @access public
 * @param string $msg
 * @return void
 */
function _alert_back($msg){
	echo "<script>alert('$msg');history.back();</script>";
	exit();
}
/**
 * _alert_back_back  js弹窗提示、后退历史二格
 * @access public
 * @param string $msg
 * @return void
 */
function _alert_back_back($msg){
	echo "<script>alert('$msg');history.go(-2);</script>";
	exit();
}
/**
 * _alert单纯的弹窗信息
 * Enter description here ...
 * @param $msg  弹窗信息
 */
function _alert($msg){
	echo "<script>alert('$msg');</script>";
	exit();
}
/**
 * _location js事先页面跳转，第一个参数可以为空
 * @access punlic
 * @param $_info  弹窗信息
 * @param $_url	  跳转到的url
 * @return void
 */
function _location($_info,$_url) {
	if (!empty($_info)) {
		echo "<script>alert('$_info');location.href='$_url';</script>";
		exit();
	} else {
		header('Location:'.$_url);
		exit();
	}
}


/**
 * _cut()标题截取函数
 * @param $_string
 */
function _cut($_string,$_strlen) {
	if (mb_strlen($_string,'utf-8') > $_strlen) {
		$_string = mb_substr($_string,0,$_strlen,'utf-8').'...';
	}
	return $_string;
}

/**
 * _mysql_string导入数据库前的处理函数
 * @access public
 * @param string $string
 * @return string $string
 */
/**
 * _level数据库里的权限判断
 * @access public
 * @param $level 等级数字123
 * @return 返回文字型权限
 */
function _level($level){
	if($level==1){
		return '普通用户';
	}
	if($level==2){
		return '管理员';
	}
	if($level==3){
		return '超级管理员';
	}
}
function _mysql_string($string){
	if(GPC){
		return $string;
	}else{
		return mysql_real_escape_string($string);
	}
}
/**
 * _msg跳转时的提示信息
 * @param string $type s代表成功信息，f代表失败信息
 * @param string $msg  显示的字幕，换行用br最后一句不要换行
 * @param string $url  跳转到的地址
 */
function _msg($type,$msg,$url){	
	if($type=='s'){
		echo "<div id='msg'><img src='images/s.gif' /> $msg<br>正在跳转......<a href='$url'>手动跳转</a><br><img src='images/wait_1.gif' /><meta http-equiv=\"refresh\" content=\"2; url=$url\" /></div>";
	}
	if($type=='f'){
		echo "<div id='msg'><img src='images/f.gif' /> $msg<br>正在跳转......<a href='$url'>手动跳转</a><br><img src='images/wait_1.gif' /><meta http-equiv=\"refresh\" content=\"2; url=$url\" /></div>";
	}
}
/**
 * _page分页函数
 * @access public
 * @param int $num 总记录数
 * @param int $size 每页显示数
 */
function _page($num,$size){
	//这里需要用全局变量$pagesize，所以不可以把参数命名为$pagesize
	global $page,$pageabsolute,$pagenum,$pagesize;
	if(isset($_GET['page'])){
		$page = $_GET['page'];
		if(empty($page) or $page<0 or !is_numeric($page)){
			$page = 1;
		}else {
			$page = intval($page);
		}
	}else{
		$page = 1;
	}
	$pagesize =$size;
	//此句在本页多余，但在其他情况下可能有用
	if($num == 0){
		$pageabsolute=1;
	}else{
	$pageabsolute=ceil($num/$pagesize);
	}
	if($page>$pageabsolute){
		$page = $pageabsolute;
	}
	//此句要放在上面判断语句的下面
	$pagenum = ($page-1)*$pagesize;
}
/**
 * _paging分页选择函数
 * @access public
 * @param $type  1数字分页，2文本分页
 */
function _paging($type){
	global $pageabsolute,$page,$num;
	if($type==1){
		echo '<div id="page_num">';
		echo '<ul>';
			for($i=1;$i<=$pageabsolute;$i++)
				if($page==$i){
					echo '<li><a href="'.SCRIPT.'.php?page='.$i.'" class="selected">'.$i.'</a></li>';
				}else{
					echo '<li><a href="'.SCRIPT.'.php?page='.$i.'">'.$i.'</a></li>';
				}		
		echo '</ul>';
		echo '</div>';
	}elseif ($type==2){
		echo '<div id="page_text">';
		echo '<ul>';
			echo '<li>'.$page.'/'.$pageabsolute.' | </li>';
			echo '<li>共有<strong>'.$num.'</strong>条记录 | </li>';
			if($page==1){
				echo '<li>首页 | </li>';
				echo '<li>上一页 | </li>';
			}else{
				echo '<li><a href="'.SCRIPT.'.php">首页</a> | </li>';
				echo '<li><a href="'.SCRIPT.'.php?page='.($page-1).'">上一页</a> | </li>';
			}
			if($page==$pageabsolute){
				echo '<li>下一页 | </li>';	
				echo '<li>尾页</li>';
			}else{
				echo '<li><a href="'.SCRIPT.'.php?page='.($page+1).'">下一页</a> | </li>';	
				echo '<li><a href="'.SCRIPT.'.php?page='.$pageabsolute.'">尾页</a></li>';
			}			
		echo '</ul>';
		echo '</div>';	
	}
}
/**
 * _time执行耗时
 * @access public
 * @return 返回microtime的时间和
 */
function _time(){
	$time=explode(' ', microtime());
	return $time[0]+$time[1];
}
/**
 * _code()是验证码函数
 * @access public 
 * @param int $_width 表示验证码的长度
 * @param int $_height 表示验证码的高度
 * @param int $_rnd_code 表示验证码的位数
 * @param bool $_flag 表示验证码是否需要边框 
 * @return void 这个函数执行后产生一个验证码
 */
function _code($_width = 75,$_height = 25,$_rnd_code = 4,$_flag = false) {
	
	//创建随机码
	for ($i=0;$i<$_rnd_code;$i++) {
		$_nmsg .= dechex(mt_rand(0,15));
	}
	
	//保存在session
	$_SESSION['code'] = $_nmsg;
	
	//创建一张图像
	$_img = imagecreatetruecolor($_width,$_height);
	
	//白色
	$_white = imagecolorallocate($_img,255,255,255);
	
	//填充
	imagefill($_img,0,0,$_white);
	
	if ($_flag) {
		//黑色,边框
		$_black = imagecolorallocate($_img,0,0,0);
		imagerectangle($_img,0,0,$_width-1,$_height-1,$_black);
	}
	
	//随即画出6个线条
	for ($i=0;$i<6;$i++) {
		$_rnd_color = imagecolorallocate($_img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
		imageline($_img,mt_rand(0,$_width),mt_rand(0,$_height),mt_rand(0,$_width),mt_rand(0,$_height),$_rnd_color);
	}
	
	//随即雪花
	for ($i=0;$i<100;$i++) {
		$_rnd_color = imagecolorallocate($_img,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255));
		imagestring($_img,1,mt_rand(1,$_width),mt_rand(1,$_height),'*',$_rnd_color);
	}
	
	//输出验证码
	for ($i=0;$i<strlen($_SESSION['code']);$i++) {
		$_rnd_color = imagecolorallocate($_img,mt_rand(0,100),mt_rand(0,150),mt_rand(0,200));
		imagestring($_img,5,$i*$_width/$_rnd_code+mt_rand(1,10),mt_rand(1,$_height/2),$_SESSION['code'][$i],$_rnd_color);
	}
	
	//输出图像
	header('Content-Type: image/png');
	imagepng($_img);
	
	//销毁
	imagedestroy($_img);
}
?>