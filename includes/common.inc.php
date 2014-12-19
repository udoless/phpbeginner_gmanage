<?php
/**
*2012-7-28   By:NaV!
*/
//防止恶意调用
if (!defined('IN_GM')) {
	exit('Access Defined!');
}
error_reporting(E_ERROR);
session_start();
//设置字符集编码
header('Content-Type: text/html; charset=utf-8');
//转换硬路径常量
define('ROOT_PATH',substr(dirname(__FILE__),0,-8)); //一旦网站根目录的下一个文件夹就不行了
//define('ROOT_PATH',$_SERVER["DOCUMENT_ROOT"]);   //指的是www目录
//创建一个自动转义状态的常量
define('GPC',get_magic_quotes_gpc());
//引入函数库
require ROOT_PATH.'includes/global.func.php';
require ROOT_PATH.'includes/mysql.func.php';

//数据库连接
define('DB_HOST', 'localhost');  //地址
define('DB_USER', 'root');       //用户名
define('DB_PWD', 'admin');            //密码
define('DB_NAME', 'gmanage');    //数据库名
//初始化数据库
_connect();
_select_db();
_set_names();

//执行耗时
$start_time=_time();


////系统设置----若未调用该文件，需要把$_system数组申明为全局变量
//$_system=array();
////网站标题
//$_system['webname'] = "计算机学院研究生档案管理";
////是否开启注册,1开，0关
//$_system['register'] = 1;
////是否需要验证码,1要，0不要
//$_system['needcode'] = 0;    
////登陆界面的提示信息
//$_system['help_login'] = "*用户名为学号<br/>*初始密码是：123456<br/>*如果你的密码不正确可能是被重置了<br/>*忘记密码请联系管理员";
////user_date页面分页类型及每页数据数
//$_system['user_date_page']=2;
//$_system['user_date_pagesize']=10;
////stu_active页面分页类型及每页数据数
//$_system['stu_active_page']=1;
//$_system['stu_active_pagesize']=30;
////message_page页面分页类型及每页数据数
//$_system['message_page']=1;
//$_system['message_pagesize']=3;
////notice_admin页面分页类型及每页数据数
//$_system['notice_page']=2;
//$_system['notice_pagesize']=3;
////stu_date页面分页类型及每页数据数
//$_system['stu_date_page']=2;
//$_system['stu_date_pagesize']=4;
////funds_admin页面分页类型及每页数据数
//$_system['funds_admin_page']=2;
//$_system['funds_admin_pagesize']=4;
////初始密码
//$_system['initial_password']='123456';

//网站系统设置初始化
if (!!$_rows = _fetch_array("SELECT 
													gm_webname,
													gm_initial_password,
													gm_register,
													gm_needcode,
													gm_help_login,
													gm_user_date_page,
													gm_stu_active_page,
													gm_stu_date_page,
													gm_message_page,
													gm_notice_page,
													gm_funds_admin_page,
													gm_user_date_pagesize,
													gm_stu_active_pagesize,
													gm_stu_date_pagesize,
													gm_message_pagesize,
													gm_notice_pagesize,
													gm_funds_admin_pagesize,
													gm_inputDetails
												FROM 
													gm_system 
											 WHERE 
													gm_id=1
													LIMIT 1"
)) {
	$_system = array();
	$_system['webname'] = $_rows['gm_webname'];
	$_system['initial_password'] = $_rows['gm_initial_password'];
	$_system['register'] = $_rows['gm_register'];
	$_system['needcode'] = $_rows['gm_needcode'];
	$_system['help_login'] = $_rows['gm_help_login'];
	$_system['user_date_page'] = $_rows['gm_user_date_page'];
	$_system['stu_active_page'] = $_rows['gm_stu_active_page'];
	$_system['stu_date_page'] = $_rows['gm_stu_date_page'];
	$_system['message_page'] = $_rows['gm_message_page'];
	$_system['notice_page'] = $_rows['gm_notice_page'];
	$_system['funds_admin_page'] = $_rows['gm_funds_admin_page'];
	$_system['user_date_pagesize'] = $_rows['gm_user_date_pagesize'];
	$_system['stu_active_pagesize'] = $_rows['gm_stu_active_pagesize'];
	$_system['stu_date_pagesize'] = $_rows['gm_stu_date_pagesize'];
	$_system['message_pagesize'] = $_rows['gm_message_pagesize'];
	$_system['notice_pagesize'] = $_rows['gm_notice_pagesize'];
	$_system['funds_admin_pagesize'] = $_rows['gm_funds_admin_pagesize'];
	$_system['inputDetails'] = $_rows['gm_inputDetails'];
} else {
	exit('数据库系统设置表异常，请管理员检查！');
}












?>