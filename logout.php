<?php
//正確的登出session方法：
//1開啟session
session_start();

//2、清空session資訊
$_SESSION = array();

//3、清楚客戶端sessionid
if(isset($_COOKIE[session_name()]))
{
    setCookie(session_name(),'',time()-3600,'/');
}
//4、徹底銷燬session
session_destroy();
?>
