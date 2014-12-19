<?php
/**
*2012-8-22  |  By:NaV!
*/
//防止恶意调用
define('IN_GM',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','message_s');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
//判断登录状态和权限
_login_state(1);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
	require ROOT_PATH.'includes/title_student.inc.php';
?>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header_student.inc.php';
?>
<div id="main">
	  <!--list start-->
	  <div id="list">
		<!--listmain start-->
		<div id="listmain">
	<?php
		if($_GET['action']=='me')
		$sql="SELECT * FROM gm_message WHERE gm_num='{$_SESSION['num']}' ORDER BY gm_systime DESC";
		else
		$sql="SELECT * FROM gm_message ORDER BY gm_systime DESC";
		$num=_num_rows($sql);
		//分页模块
		_page($num,$_system['message_pagesize']);
		$res=_query($sql." LIMIT $pagenum,$pagesize");
		if($num!=0)
		{
			for($i=1;$i<=$pagesize;$i++)
			{
				$row=_fetch_array_list($res);
				if($row['gm_id']=='')
					break;
				?>
				<h2>
					<span class="leftarea">
						<?=$i?>#<img src="images/icon_write.gif" /> <?php echo $row['gm_username'];?><font style="color:#999;">于<?php echo date("Y-m-d H:i",strtotime($row["gm_systime"]));?>发表留言</font>
						<?php if(date("Y-m-d",strtotime($row["gm_systime"]))==date("Y-m-d",time()+8*3600))  echo '<img src=images/new.gif>';?>	
					</span>
				</h2>
				<div class="content">
					<?php 
						echo $row['gm_content'];
					?>
				</div>
				<?php

				if(!empty($row['gm_reply'])){?>
					<div class="reply">
						<p><span style="color:#f93"><b>管理员-回复</b><?php echo date("Y-m-d H:i",strtotime($row["gm_replytime"]));?></span></p>
						<?php echo $row['gm_reply'];?>
					</div>
					<?php 
				}
			}
		}
		else{
			echo '你还没有发表任何留言哦~　<a href="message_add_s.php" class="xzfb">现在发表</a>';
		}
		?>
		</div>
		<!--listmain end-->
		</div>
		<!--list end-->	
		<?php 
		//引入分页
		_paging($_system['message_page']);
		?>

</div>
<?php 
	require ROOT_PATH.'includes/footer_student.inc.php';
?>
</body>
</html>