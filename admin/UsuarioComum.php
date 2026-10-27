<?php 

if (!isset($_SESSION)) session_start();

if (!$_SESSION["USER"])
{
    $_SESSION["notAuth"] =
    '
    <div id="login-status-message-container">
        <span class="status-message">OPS! Somente usuários cadastrados podem acessar este conteúdo!</span>
    </div>
    ';

    header("Location: ../Index.php");
}

?>