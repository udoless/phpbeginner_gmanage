<?php
/**
*2012-8-19   By:NaV!
*/
//防止恶意调用
define('IN_GM',true);
session_start();
session_destroy();
?>
<script type="text/javascript">
window.location.replace("login.php");
</script>