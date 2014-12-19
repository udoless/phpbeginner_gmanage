<?php
/**
*2012-9-29   By:NaV!
*/
//防止恶意调用
define('IN_GM',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','export');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
//判断登录状态和权限
_login_state(2);
if($_POST['submit']){
$filename=$_POST['source'].".xls";
header('Content-type:application/x-msexcel'); 
header("Content-Disposition: attachment; filename=$filename" );
if($_POST['source']=='yjsxx'){
	$sql="SELECT * FROM gm_stuinfo WHERE gm_active='1'";
	$num=_num_rows($sql);
	$res=_query($sql);
	echo "序号\t姓名\t学号\t导师\t性别\t年级\t培养类型\t专业\t家庭住址\n";
	for($i=0;$i<$num;$i++){	
		$row=_fetch_array_list($res);
		if($row['gm_teacher']==NULL OR $row['gm_teacher']=='')
			$row['gm_teacher']='无';
		echo ($i+1)."\t".$row['gm_username']."\t".$row['gm_num']."\t".$row['gm_teacher']."\t".$row['gm_sex']."\t".$row['gm_grade']."\t".$row['gm_type']."\t".$row['gm_subject']."\t".$row['gm_address']."\n";
	}
}
if($_POST['source']=='dsxx'){
	$sql="SELECT * FROM gm_teacher";
	$num=_num_rows($sql);
	$res=_query($sql);
	echo "序号\t姓名\t工号\t职称\t剩余经费\t学生数\t学生姓名\n";
	for($i=0;$i<$num;$i++){
		$student='';
		$row=_fetch_array_list($res);
		$student_arr=explode(",",$row['gm_student']);
		for($j=0;$j<count($student_arr);$j++){
			$rows=_fetch_array("SELECT gm_username FROM gm_stuinfo WHERE gm_num='{$student_arr[$j]}'");
			$student.='  '.$rows['gm_username'];
		}
		if($student=='  '){
			//count($student_arr)在没有学生的情况下还是1
			$student_arr=NULL;
			$student='无';
		}
		//$row['gm_num']="'".$row['gm_num'];
		echo ($i+1)."\t".$row['gm_username']."\t".$row['gm_num']."\t".$row['gm_zc']."\t".$row['gm_funds']."\t".count($student_arr)."\t".$student."\n";
	}
}
if($_POST['source']=='czjl'){
	//引入资金专用函数库
	require dirname(__FILE__).'/includes/funds.func.php';
	$sql="SELECT * FROM gm_funds AS f INNER JOIN gm_teacher AS t ON f.gm_num=t.gm_num ORDER BY f.gm_time DESC,f.gm_num,f.gm_lmoney DESC";
	$num=_num_rows($sql);
	$res=_query($sql);
	echo "序号\t操作种类\t姓名\t工号\t操作日期\t支出/收入\t剩余经费\t摘要\n";
	for($i=0;$i<$num;$i++){
		$row=_fetch_array_list($res);
		$type=_check_funds_type($row['gm_ftype']);
		if($type=='<i>撤销</i>')
			$type='撤销';
		if($row['gm_ftype']==10 OR $row['gm_ftype']==20)
			$type.="[已撤销]";
		echo ($i+1)."\t".$type."\t".$row['gm_username']."\t".$row['gm_num']."\t".$row['gm_time']."\t".$row['gm_money']."\t".$row['gm_lmoney']."\t".$row['gm_details']."\n";
	}
}
}
?>