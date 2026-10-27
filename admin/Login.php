<?php 

require_once __DIR__ . "/../connection/connection.php";
if (!isset($_SESSION)) session_start();

// Verificando usuário e senha para comparar informações do banco de dados
if (isset($_POST["usuario"]) && $_POST["usuario"] != "" && isset($_POST["senha"]) && $_POST["senha"] != "")
{
    $usuario = $_POST["usuario"];
    $senha   = $_POST["senha"];

    $sql = "SELECT * FROM funcionario WHERE usuario = :usuario AND senha = :senha";

    try
    {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":usuario" => $usuario, ":senha" => $senha]);
        $res = $stmt->fetch();

        if ($res)
        {
            $_SESSION["ID"]   = $res["id_func"];
            $_SESSION["USER"] = $res["usuario"];
            $_SESSION["TYPE"] = $res["tipo_acesso"];
            $_SESSION["NAME"] = $res["nome"];

            header("Location: dashboard/dashboard.php");
        }
        else
        {
            $_SESSION["loginError"] =
            '
            <div id="login-status-message-container">
                <span class="status-message">Usuário ou senha inválidos!</span>
            </div>
            ';

            header("Location: Index.php");
        }

    }
    catch (PDOException $e) {}
}
else
{
    $_SESSION["emptyLogin"] =
    '
    <div id="login-status-message-container">
        <span class="status-message">Preencha os campos!</span>
    </div>
    ';

    header("Location: Index.php");
}

?>