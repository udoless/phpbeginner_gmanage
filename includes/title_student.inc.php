<?php
/**
*2012-8-22   By:NaV!
*/
//防止恶意调用
if(!defined('IN_GM')){
	exit('Access Defined!');
}
//防止非HTML页面调用
if(!defined('SCRIPT')){
	exit('SCRIPT Error!');
}
global $_system;
?>
<title><?php echo $_system['webname']?></title>
<link rel="stylesheet" type="text/css" href="styles/basic.css" />
<link rel="stylesheet" type="text/css" href="styles/header.css" />
<link rel="stylesheet" type="text/css" href="styles/<?php echo SCRIPT;?>.css" />
<script src="js/header.js" type="text/javascript"></script>
<script src="js/basic.js" type="text/javascript"></script>