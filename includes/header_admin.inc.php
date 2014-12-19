<?php 
/**
*2012-7-28   By:NaV!
*/
//防止恶意调用
if (!defined('IN_GM')) {
	exit('Access Defined!');
}
?>
<div id="body">
<div id="banner"><img src="images/loginlogo.png" /></div>
<div id="nav">
<div id="menu">
  <ul>
    
    <li id="m_1" class='m_li' onmouseover='mover(1);' onmouseout='mout(1);' onclick='mclick(1)'><a href="admin.php">首页</a></li>
    <li class="m_line"><img src="images/line2.gif" /></li>
	<li id="m_2" class='m_li' onmouseover='mover(2);' onmouseout='mout(2);' onclick='mclick(2)'><a href="user_data.php">用户信息</a></li>
	<li class="m_line"><img src="images/line2.gif" /></li>
    <li id="m_3" class='m_li' onmouseover='mover(3);' onmouseout='mout(3);' onclick='mclick(3)'><a href="stu_date.php">研究生信息</a></li>
    <li class="m_line"><img src="images/line2.gif" /></li>
    <li id="m_4" class='m_li' onmouseover='mover(4);' onmouseout='mout(4);' onclick='mclick(4)'><a href="funds_admin.php">经费管理</a></li>
    <li class="m_line"><img src="images/line2.gif" /></li>
    <li id="m_5" class='m_li' onmouseover='mover(5);' onmouseout='mout(5);' onclick='mclick(5)'><a href="notice_admin.php">公告中心</a></li>
    <li class="m_line"><img src="images/line2.gif" /></li>
    <li id="m_6" class='m_li' onmouseover='mover(6);' onmouseout='mout(6);' onclick='mclick(6)'><a href="message_admin.php">查看留言</a></li>
    <li class="m_line"><img src="images/line2.gif" /></li>
	<li id="m_7" class='m_li' onmouseover='mover(7);' onmouseout='mout(7);' onclick='mclick(7)'><a href="###">其它</a></li>
   
  </ul>  
</div>
<div style="height:32px; background-color:#F1F1F1;">
   <ul class="smenu">
     <li style="padding-left:4%;" id="s_1" class='s_li'>功能正在不断完善中！</li>
	 <li <?php if($_SESSION['level']<3)echo 'style="padding-left:15%;"'; else echo 'style="padding-left:11%;"';?>id="s_2" class='s_li' onmouseover='mover(2);' onmouseout='mout(2);'>
	 <a href="user_data.php">全部用户</a>  |  <a href="user_data.php?action=one">搜索</a>  |  <?php if($_SESSION['level']==3)echo '<a href="###" onclick=document.getElementById("addadmin").style.display="block">添加管理员</a>  |  '; ?><a href="###" onclick="document.getElementById('pass_modify').style.display='block'">修改密码</a></li>
     <li style="padding-left:17%;" id="s_3" class='s_li' onmouseover='mover(3);' onmouseout='mout(3);'><a href="stu_date.php">查看全部</a>  |  <a href="stu_date.php?action=one">搜索</a>  |  <a href="stu_active.php">信息审核</a>  |  <a href="teacher_match.php?action=some">导师分配</a>  |  <a href="teacher_data.php">导师信息</a>  |  <a href="add_teacher.php?action=add">添加导师</a>  |  <a href="stu_update.php">更新信息</a></li>
     <li style="padding-left:43%;" id="s_4" class='s_li' onmouseover='mover(4);' onmouseout='mout(4);'><a href="funds_admin.php">全部记录</a>  |  <a href="funds_add_admin.php">经费操作</a></li>
     <li style="padding-left:56.5%;" id="s_5" class='s_li' onmouseover='mover(5);' onmouseout='mout(5);'><a href="notice_admin.php">查看公告</a>  |  <a href="notice_edit_admin.php?action=add">发布公告</a></li>
     <li style="padding-left:68.8%;" id="s_6" class='s_li' onmouseover='mover(6);' onmouseout='mout(6);'><a href="message_admin.php">全部留言</a>  |  <a href="message_admin.php?action=some">未回复留言</a></li>
	 <li style="padding-left:78%;" id="s_7" class='s_li' onmouseover='mover(7);' onmouseout='mout(7);'><a href="set_admin.php">后台管理</a>  |  <a href="export.php">数据导出</a>  |  <a href="logout.php">安全退出</a></li>     
   </ul>
</div>
</div>

<div id="addadmin">
	<p>添加管理员<img src='images/close.png' onclick="document.getElementById('addadmin').style.display='none'" /></p>
	<form action='user_data.php?action=addadmin' method='post'>
		<dl>
			<dt></dt>
			<dd>登录帐号：<input type='text' name='num' /></dd>
			<dd>密　　码：<input type='text' name='password' /></dd>
			<dd><input type='submit' value='提 交' class='button'/></dd>
		</dl>
	</form>
</div>
<div id="pass_modify">
	<p>修改密码<img src='images/close.png' onclick="document.getElementById('pass_modify').style.display='none'" /></p>
	<form action='user_data.php?action=pass_modify' method='post'>
		<dl>
			<dt></dt>
			<dd>旧密码：<input type='text' name='password' /></dd>
			<dd>新密码：<input type='text' name='newpassword' /></dd>
			<dd><input type='submit' value='提 交' class='button'/></dd>
		</dl>
	</form>
</div>