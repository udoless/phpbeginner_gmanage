<?php
/**
*2012-8-18   By:NaV!
*/
function _check_money($money){
	if($money>0){
		return "<span style=\"color:blue;font-weight:bold\">+$money</span>";	
	}else {
		$money=abs($money);
		return "<span style=\"color:red;font-weight:bold\">- $money</span>";	
	}
}

function _check_funds_type($type){
	if($type==1 or $type==10){
		return "按导师"; 
	}else if($type==2 OR $type==20){
		return "按学生";
	}else if($type==0){
		return "<i>撤销</i>";
	}
}

function _check_post($p){
	$temp=array();
	$n=0;
	foreach($p as $k=>$v){
		if($v){
			if($k=="gm_money")
				array_push($temp,$k.$v);
			else
				array_push($temp,$k."'".$v."'");		
			$a=1;
		}	
		$n++;	
	}
	if($a!=1)
		return "";
	else{	
		return implode(" AND ",$temp);
	}
}

function _check_details($content){
//取出二边空格
	$content=trim($content);
	//判断是否为空
	if($content==''){
		_alert_back('事由不可以为空！');
	}
	//判断是否含有敏感字符
	$char_patern='/[<>\'\"\ ]/';
	if(preg_match($char_patern, $content)){
		_alert_back('内容不得包含敏感字符！');
	}
	return _mysql_string($content);
}
?>