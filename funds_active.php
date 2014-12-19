<?php
/**
*2012-9-4   By:NaV!
*/
//防止恶意调用
define('IN_GM',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','funds_active');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
//判断登录状态和权限
_login_state(2);
//引入资金专用函数库
require dirname(__FILE__).'/includes/funds.func.php';
if($_GET['action']==""){
	if($num=_num_rows("SELECT * FROM gm_funds AS f INNER JOIN gm_stuinfo AS s ON f.gm_num=s.gm_num WHERE f.gm_active='0'")){
		//分页模块
		_page($num,$_system['funds_admin_pagesize']);
		$res=_query("SELECT * FROM gm_funds AS f INNER JOIN gm_stuinfo AS s ON f.gm_num=s.gm_num  WHERE f.gm_active='0' ORDER BY f.gm_time DESC,f.gm_num LIMIT $pagenum,$pagesize");
	}
}

//开始激活处理、删除
if(!empty($_GET['id']) and !empty($_GET['action'])){
if ($row=_fetch_array("SELECT * FROM gm_funds WHERE gm_fid='{$_GET['id']}' and gm_active='0' LIMIT 1")){
		//激活
		if($_GET['action']==pass){
		if(_query("UPDATE gm_funds SET gm_active='1',gm_bynum='{$_SESSION['num']}' WHERE gm_fid='{$_GET['id']}'") and _query("UPDATE gm_stuinfo SET gm_funds=gm_funds+'{$row['gm_money']}' WHERE gm_num='{$row['gm_num']}'")){
			_location('审核成功！', 'funds_active.php');
		}else{
			_location('审核失败！', 'funds_active.php');
		}
		}
		//删除
		if($_GET['action']==del){
		if(_query("DELETE FROM gm_funds WHERE gm_fid='{$_GET['id']}'")){
			_alert_back('删除成功！');
		}else{
			_alert_back('删除失败！');
		}
		}
	}
	else{
		_alert_back('要操作的记录不存在！');
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
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header_admin.inc.php';
?>
<div id="main">
<?php 
//判断是否有需要审核的学生
if($num==0){
		echo "<span class='ex'>暂时没有经费信息需要审核</span>";
	}else{
?>
<table class="sortableTable">
		<thead>
			<tr>
				<th class="sortableCol"  valuetype="number">序号</th>
				<th class="sortableCol" >姓名</th>
				<th class="sortableCol"  valuetype="number">学号</th>
				<th class="sortableCol" >性别</th>
				<th class="sortableCol" >年级</th>
				<th class="sortableCol" >专业</th>
				<th class="sortableCol" >管理类型</th>
				<th class="sortableCol">申请时间</th>
				<th class="sortableCol">金额</th>
				<th class="sortableCol" >事由</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		for($i=1;$i<=$pagesize;$i++){
			$rows=_fetch_array_list($res);
			if($rows['gm_num']=='')
				break;
			$gm_details=_cut($rows['gm_details'], 10);	
			$rows['gm_ftype']=_check_funds_type($rows['gm_ftype']);
			$rows['gm_money']=_check_money($rows['gm_money']);		
			echo "<tr><td>$i</td><td><a href='stu_date_one.php?num={$rows['gm_num']}' class='a'>{$rows['gm_username']}</a></td><td>{$rows['gm_num']}</td><td>{$rows['gm_sex']}</td><td>{$rows['gm_grade']}</td><td>{$rows['gm_subject']}</td><td>{$rows['gm_type']}</td><td>{$rows['gm_time']}</td><td><b>{$rows['gm_money']}</b></td><td title='{$rows['gm_details']}'>$gm_details</td><td><a href='###' onclick=_confirm('确定通过该条申请吗？','funds_active.php?action=pass&id={$rows['gm_fid']}')>通过 </a> <a href='###' onclick=_confirm('确定删除该条申请吗？','funds_active.php?action=del&id={$rows['gm_fid']}')>删除</a></td></tr>";
		}	
		?>
		</tbody>
	</table>
<?php 
//引入分页
if($_GET['action']=='')
_paging($_system['funds_admin_page']);
echo "<p class='record'>共有<span>$num</span>条信息需要审核</p>";
	}
 ?>
</div>
<?php 
	require ROOT_PATH.'includes/footer_admin.inc.php';
?>
</body>
</html>