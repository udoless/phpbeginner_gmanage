<?php
/**
*2012-7-28   By:NaV!
*/
//防止恶意调用
if (!defined('IN_GM')) {
	exit('Access Defined!');
}
/**
 * _connect 连接数据库
 */
function _connect(){
	if(!mysql_connect(DB_HOST,DB_USER,DB_PWD)){
		exit('数据库连接失败！');
	}
}
/**
 * _select_db 选择数据库
 */
function _select_db(){
	if(!mysql_select_db(DB_NAME)){
		exit('找不到数据库：'.DB_NAME);
	}
}
/**
 * _set_names 设置字符集
 */
function _set_names(){
	if(!mysql_query('set names utf8')){
		exit('设置字符集出现错误！');
	}
}
/**
 * _query mysql_query执行结果
 * @access public
 * @param string $sql
 * @return 返回一个结果集
 */
function _query($sql){
	return mysql_query($sql);
}
/**
 * _fetch_array 和query结果集作用后的结果
 * @access public
 * @param string $sql
 * @return 返回执行结果数组
 */
function _fetch_array($sql){
	return mysql_fetch_array(_query($sql));
}
/**
 * _fetch_array 单纯的mysql_fetch_array执行结果
 * @access public
 * @param string $res 结果集
 * @return 返回执行结果数组
 */
function _fetch_array_list($res){
	return mysql_fetch_array($res);
}
/**
 * _num_rows返回结果集包含的结果个数，参数为语句
 * @access public
 * @param $sql 数据库执行语句
 * @return 返回个数
 */
function _num_rows($sql){
	return 	mysql_num_rows(_query($sql));	
}
/**
 * _num_rows_list返回结果集包含的结果个数，参数为结果集
 * Enter description here ...
 * @param $res
 */
function _num_rows_list($res){
	return 	mysql_num_rows($res);	
}
/**
 * _is_repeat判断插入信息在数据库里是否重复
 * @access public
 */
function _is_repeat($sql,$info){
	if(_fetch_array($sql)){
		_alert_back($info);
	}
}














?>