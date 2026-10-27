<?php 

if (!isset($_SESSION)) session_start();
unset($_SESSION["USER"], $_SESSION["TYPE"]);
$_SESSION["logOff"] = 
'
<div id="login-status-message-container">
    <span class="status-message">Você saiu de sua conta com sucesso!</span>
</div>
';

header("Location: Index.php");

?>