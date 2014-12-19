<?php 
/**
*2012-8-22   By:NaV!
*/
//防止恶意调用
if (!defined('IN_GM')) {
	exit('Access Defined!');
}
$end_time=_time();
?>
<div id="footer">执行耗时:<span><?php echo round($end_time-$start_time,4);?></span>s<br>&copy;安徽工业大学计算机学院</div>
</div>