<?php
require_once 'settings.php';
setcookie(COOKI, "", time()-60*60*24*100, "/");
header('Location:index.php');
?>
