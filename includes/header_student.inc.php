<?php 
/**
*2012-8-22   By:NaV!
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
  <ul class="student" style="margin-left:20%;">
    <li id="m_1" class='m_li' onmouseover='mover(1);' onmouseout='mout(1);' onclick='mclick(1)'><a href="student_s.php">首页</a></li>
    <li class="m_line"><img src="images/line2.gif" /></li>
	<li id="m_2" class='m_li' onmouseover='mover(2);' onmouseout='mout(2);' onclick='mclick(2)'><a href="stu_data_s.php?action=aboutme">个人信息</a></li>
	<li class="m_line"><img src="images/line2.gif" /></li>
    <li id="m_4" class='m_li' onmouseover='mover(4);' onmouseout='mout(4);' onclick='mclick(4)'><a href="notice_s.php">公告中心</a></li>
    <li class="m_line"><img src="images/line2.gif" /></li>
    <li id="m_5" class='m_li' onmouseover='mover(5);' onmouseout='mout(5);' onclick='mclick(5)'><a href="message_s.php">查看留言</a></li>
    <li class="m_line"><img src="images/line2.gif" /></li>
    <li id="m_6" class='m_li' onmouseover='mover(6);' onmouseout='mout(6);' onclick='mclick(6)'><a href="logout.php">安全退出</a></li>
  </ul>  
</div>
<div style="height:32px; background-color:#F1F1F1;">
   <ul class="smenu">
     <li style="padding-left:15%;" id="s_1" class='s_li'>功能正在不断完善中！</li>
	 <li style="padding-left:27%;" id="s_2" class='s_li' onmouseover='mover(2);' onmouseout='mout(2);'>
	 <a href="stu_data_s.php?action=aboutme">个人信息</a>  |  <a href="###" onclick="document.getElementById('pass_modify').style.display='block'">修改密码</a></li>
     <li style="padding-left:44%;" id="s_4" class='s_li' onmouseover='mover(4);' onmouseout='mout(4);'><a href="notice_s.php">全部公告</a></li>
     <li style="padding-left:50%;" id="s_5" class='s_li' onmouseover='mover(5);' onmouseout='mout(5);'><a href="message_s.php">全部留言</a>  |  <a href="message_s.php?action=me">我的留言</a>  |  <a href="message_add_s.php">发表留言</a></li>
     <li style="padding-left:70%;" id="s_6" class='s_li' onmouseover='mover(6);' onmouseout='mout(6);'></li>
	 
   </ul>
</div>
</div>

<div id="pass_modify">
	<p>修改密码<img src='images/close.png' onclick="document.getElementById('pass_modify').style.display='none'" /></p>
	<form action='stu_data_s.php?action=pass_modify' method='post'>
		<dl>
			<dt></dt>
			<dd>旧密码：<input type='text' name='password' /></dd>
			<dd>新密码：<input type='text' name='newpassword' /></dd>
			<dd><input type='submit' value='提 交' class='button'/></dd>
		</dl>
	</form>
</div>