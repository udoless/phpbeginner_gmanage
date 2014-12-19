<?php
/**
*2012-8-18  |  By:NaV!
*/
//防止恶意调用
define('IN_GM',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','funds_admin');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
//判断登录状态和权限
_login_state(2);
//引入资金专用函数库
require dirname(__FILE__).'/includes/funds.func.php';

if($_GET['action']=="del" && $_GET['id']){
	$row=_fetch_array("SELECT gm_num,gm_money FROM gm_funds WHERE gm_fid='{$_GET['id']}'");
	$row_t=_fetch_array("SELECT gm_funds FROM gm_teacher WHERE gm_num='{$row['gm_num']}'");
	$money=$row_t['gm_funds']-$row['gm_money'];
	if($money<0)
		_alert_back("导师经费不足！无法撤销！");
	if(_query("UPDATE gm_teacher SET gm_funds=gm_funds-'{$row['gm_money']}' WHERE gm_num='{$row['gm_num']}'")
	   && _query("INSERT INTO gm_funds(
	   									gm_ftype,
	   									gm_num,
	   									gm_time,
	   									gm_money,
	   									gm_lmoney,
	   									gm_details
	   									)
	   								VALUES(
	   									'0',
	   									'{$row['gm_num']}',
	   									NOW(),
	   									'{$row['gm_money']}',
	   									'$money',
	   									'/'
	   									)") && _query("UPDATE gm_funds SET
	   											 gm_ftype=gm_ftype*10
	   											WHERE gm_fid='{$_GET['id']}'") or die(mysql_error())){
		_location('撤销成功！','funds_admin.php');
	}else{
		_location('撤销失败！','funds_admin.php');
	}
}

$get=_check_post($_POST);
//查看全部
if($get=='' && $_GET['action']==""){
if($num=_num_rows("SELECT * FROM gm_funds AS f INNER JOIN gm_teacher AS t ON f.gm_num=t.gm_num")){
	//分页模块
	_page($num,$_system['funds_admin_pagesize']);
	$res=_query("SELECT * FROM gm_funds AS f INNER JOIN gm_teacher AS t ON f.gm_num=t.gm_num ORDER BY f.gm_time DESC,f.gm_num,f.gm_lmoney DESC LIMIT $pagenum,$pagesize");
}
//查看个人
}else if($_GET['action']=='one' and $_POST['num']){
	$res=_query("SELECT * FROM gm_funds AS f INNER JOIN gm_teacher AS t ON f.gm_num=t.gm_num WHERE (f.gm_num LIKE '%{$_POST['num']}%' OR t.gm_username LIKE '%{$_POST['num']}%')");
	$pagesize=$num=_num_rows_list($res);
}else if($_GET['action']=="condition"){
	if($get==''){
		if($num=_num_rows("SELECT * FROM gm_funds AS f INNER JOIN gm_teacher AS t ON f.gm_num=t.gm_num WHERE f.gm_active='1'")){
			$pagesize=$num;
			$res=_query("SELECT * FROM gm_funds AS f INNER JOIN gm_teacher AS t ON f.gm_num=t.gm_num ORDER BY f.gm_time DESC,f.gm_num");
		}
	}else{
		if($num=_num_rows("SELECT * FROM gm_funds AS f INNER JOIN gm_teacher AS t ON f.gm_num=t.gm_num WHERE $get")){
			$pagesize=$num;
			$res=_query("SELECT * FROM gm_funds AS f INNER JOIN gm_teacher AS t ON f.gm_num=t.gm_num WHERE $get ORDER BY f.gm_time DESC,f.gm_num");
		}
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
<script type="text/javascript" src="js/sortable-table.js"></script>
<script type="text/javascript" src="js/funds.js"></script>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header_admin.inc.php';
?>
<div id="main">
<?php 
//搜索，公用的
	echo "<div id='search'><form action='funds_admin.php?action=one' method='post'>工号/姓名：<input type='text' name='num' class='search' /> <input type='image' src='images/search.gif' alt='搜索' class='img'/></form></div>";
?>
	<table class="sortableTable">
		<thead>
			<tr>
				<th class="sortableCol"  valuetype="number">序号</th>
				<th class="sortableCol" >操作种类</th>
				<th class="sortableCol" >姓名</th>
				<th class="sortableCol"  valuetype="number">工号</th>
				<th class="sortableCol">操作时间</th>
				<th class="sortableCol">支出/收入</th>
				<th class="sortableCol">剩余经费</th>
				<th class="sortableCol" >摘要</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		for($i=1;$i<=$pagesize;$i++){
			$rows=_fetch_array_list($res);
			if($rows['gm_num']=='')
				break;
			$gm_details=_cut($rows['gm_details'], 15);	
			$ftype=_check_funds_type($rows['gm_ftype']);
			$rows['gm_money']=_check_money($rows['gm_money']);		
			echo "<tr><td>$i</td><td>$ftype</td><td>{$rows['gm_username']}</td><td>{$rows['gm_num']}</td><td>{$rows['gm_time']}</td><td><b>{$rows['gm_money']}</b></td><td>{$rows['gm_lmoney']}</td><td title='{$rows['gm_details']}'>$gm_details</td><td>";
			if($rows['gm_ftype']==0)
				echo '/';
			else if($rows['gm_ftype']==10 OR $rows['gm_ftype']==20)
				echo '<font color="#666666">已撤销</font>';
			else
				echo "<a href='###' onclick=_confirm('确定撤销操作并删除该条记录吗？','funds_admin.php?action=del&id={$rows['gm_fid']}')>撤销</a>";
			echo "</td></tr>";
		}	
		?>
		</tbody>
	</table>
<?php 
//引入分页
if($_GET['action']=='')
_paging($_system['funds_admin_page']);
 ?>
</div>
<?php 
	require ROOT_PATH.'includes/footer_admin.inc.php';
?>
</body>
</html>