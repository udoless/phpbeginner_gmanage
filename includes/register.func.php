<?php
/**
*2012-7-28   By:NaV!
*/
//防止恶意调用
if(!defined('IN_GM')){
	exit('Access Defined!');
}
//判断_alert_back()是否存在
if(!function_exists('_alert_back')){
	exit('_alert_back函数不存在，请检查！');
}
//判断_mysql_string()是否存在
if(!function_exists('_mysql_string')){
	exit('_mysql_string函数不存在，请检查！');
}
/**
 * _check_username检查用户名
 * @access public
 * @param string $username
 * @return string $username
 */
function _check_username($username){
	//取出二边空格
	$username=trim($username);
	//判断是否为空
	if($username==''){
		_alert_back('用户名不可以为空！');
	}
	//判断是否含有敏感字符
	$char_patern='/[<>\'\"\ ]/';
	if(preg_match($char_patern, $username)){
		_alert_back('用户名不得包含敏感字符！');
	}
	return _mysql_string($username);
}
/**
 * _check_password检查密码
 * @access public
 * @param string $password
 * @return string $password
 */
function _check_password($password){
	//判断是否为空
	if($password==''){
		_alert_back('密码不可以为空！');
	}
	//转换
	return sha1($password);
}
/**
 * _check_num检查学号
 * @access public
 * @param int $num
 * @return int $num
 */
function _check_num($num){
	if(!is_numeric($num)){
		_alert_back('学号/工号必须是纯数字！');
	}
	return _mysql_string($num);
}
/**
 * _check_sex检查性别
 * @access public
 * @param string $sex
 * @return string $sex
 */
function _check_sex($sex){
	if(!($sex=='男' or $sex=='女')){
		_alert_back('性别值非法！');
	}
	return _mysql_string($sex);
}
/**
 * _checkdate检查出生年月是否合法
 * @access public
 * @param $month
 * @param $day
 * @param $year
 * @return void
 */
function _checkdate($month, $day, $year){
	if(!checkdate($month, $day, $year)){
		_alert_back('你填写的日期有误');
	}
}
/**
 * _check_time_grade把入学时间转换成年级，包含毕业的情况
 * @param $time_y 入学年份
 * @param $time_m 入学月份
 * @return 返回年级
 */
function _time_to_grade($time_y,$time_m){
	$months=(date('Y')-$time_y)*12+(date('m')-$time_m);
	$grade=ceil($months/12);
	if($grade>3)$grade=4;
	switch ($grade){
		case 1:return '研一';break;
		case 2:return '研二';break;
		case 3:return '研三';break;
		case 4:return '已毕业';break;
		default:_alert_back('入学时间信息出错！');
	}
}
/**
 * _check_contact检查联系方式
 * @access public
 * @param int $contact
 * @return int $contact
 */
function _check_contact($contact){
	if(!is_numeric($contact)){
		_alert_back('手机号码必须是纯数字！');
	}
	return _mysql_string($contact);
}


function _check_address_ex($address){
	if (!$address){
		_alert_back('地址不完整！');
	}
	//判断是否含有敏感字符
	$char_patern='/[<>\'\"\ ]/';
	if(preg_match($char_patern, $address)){
		_alert_back('住址不得包含敏感字符！');
	}
	return _mysql_string($address);
}
/**
 * _check_address检查家庭住址
 * @access public
 * @param $province
 * @param $city
 * @param $town
 * @return 返回连接在一起的住址
 */
function _check_address($province,$city,$town){
	if (empty($province)){
		_alert_back('地址不完整！');
	}
	return _mysql_string($province.$city.$town);
}

/**
 * 判断详细地址是否含有敏感字符
 * Enter description here ...
 * @param $string
 */
function _check_address_details($string){
	//判断是否含有敏感字符
	$char_patern='/[<>\'\"\ ]/';
	if(preg_match($char_patern, $string)){
		_alert_back('住址不得包含敏感字符！');
	}
	return _mysql_string($string);	
}
/**
 * _check_subject检查专业是否合法
 * @access public
 * @param string $subject
 * @return string $sunject
 */
function _check_subject($subject){
//	$subject_arr=array("计算机应用技术","计算机软件与理论","计算机技术");
//	if(!in_array($subject,$subject_arr));{
//		_alert_back('专业值非法！');
//	}
	return _mysql_string($subject);
}
/**
 * _check_type检查培养管理类型是否合法
 * @access public
 * @param string $type
 * @return string $type
 */
function _check_type($type){
//	$type_arr=array("学术型","专业型","工程型");
//	if(!in_array($type,$type_arr));{
//		_alert_back('培养管理类型值非法！');
//	}
	return _mysql_string($type);
}
/**
 * _check_photo对上传的照片进行处理
 * @access public
 * @return 返回照片名称
 */
function _check_photo(){
	//类的实例化：  
	include(ROOT_PATH."includes/upphoto.php");//类的文件名是upphoto.php  
	
	$up=new upphoto();  
	
	$up->get_ph_tmpname($_FILES['photo']['tmp_name']);  
	
	$up->get_ph_type($_FILES['photo']['type']);  
	
	$up->get_ph_size($_FILES['photo']['size']);  
	
	$up->get_ph_name($_FILES['photo']['name']);  
	
	echo $up->save();  
	
	$temp=$up->get_ph_name($_FILES['photo']['name']);//提取出上传后生成的目录和文件名
	
	return $e_image=strrchr($up->get_ph_name($_FILES['photo']['name']),"/");//去掉目录，只保留文件名及后缀，方便存入数据库
}
/**
 * _check_code检查验证码
 * @access public
 * @param string $first_code
 * @param string $end_code 
 * @return void
 */
function _check_code($first_code,$end_code){
	if(strtolower($first_code)!=strtolower($end_code)){
		_alert_back('验证码不正确！');
	}	
}
/**
 * _check_title检查标题
 * @param $title
 */
function _check_title($title){
	//取出二边空格
	$title=trim($title);
	//判断是否为空
	if($title==''){
		_alert_back("标题不可以为空！");
	}
	//判断是否含有敏感字符
	$char_patern='/[<>\'\"]/';
	if(preg_match($char_patern, $title)){
		_alert_back('标题不得包含敏感字符！\n如：英文状态下的< >和单双引号');
	}
	return _mysql_string($title);
}

function _check_email($email){
	//取出二边空格
	$email=trim($email);
	$char_patern='/^([\w\.\_]{2,10})@(\w{1,}).([a-z]{2,4})$/';
if(preg_match($char_patern, $email)){
		_alert_back('邮箱格式不正确！');
	}
	return _mysql_string($email);	
}
/**
 * _check_content检查内容
 * @param $content
 */
function _check_content($content){
	//判断是否为空
	if($content==''){
		_alert_back('内容不可以为空！');
	}
	//判断是否含有敏感字符
	$char_patern='/[<>\'\"]/';
	if(preg_match($char_patern, $content)){
		_alert_back('内容不得包含敏感字符！\n如：英文状态下的< >和单双引号');
	}
	return _mysql_string($content);
}














?>