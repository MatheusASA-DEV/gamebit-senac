<?php 

if (!isset($_SESSION)) session_start();

// Verificando se o usuário é Administrador
if ($_SESSION["TYPE"] != "1")
{
    $_SESSION["notAdmin"] =
    '
    <div id="login-status-message-container">
        <span class="status-message">OPS! Somente administradores podem acessar esta página!</span>
    </div>
    ';

    header("Location: ../dashboard/dashboard.php");
}

?>