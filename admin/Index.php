<?php

include_once __DIR__ . "/../config/config.php";

if (!isset($_SESSION)) session_start();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta author="Matheus de Andrade Silva Arruda">
    <title>Painel Administrativo | Login</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=JetBrains+Mono:ital,wght@0,100..800;1,100..800&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:ital,wght@0,100..800;1,100..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css"
        integrity="sha512-QeR2VH+lsBE5LSAe1Q5EnTBbe7XTBubt8dG93Y7gidSgdMCr8nVqKcfKAMyN96SV8KDbZVTDXChatu5G2KQGzg=="
        crossorigin="anonymous" referrerpolicy="no-referrer">

    <!-- My Styles -->
    <link rel="stylesheet" href="../custom/css/global.css">
    <link rel="stylesheet" href="../custom/css/login.css">
</head>

<body>
    <main>
        <div id="form-container">
            <!-- Formulário de Login -->
            <form action="Login.php" method="POST" id="login-form">
                <h1 id="title-login">Faça Login</h1>

                <label>
                    <span class="label-input">Usuário:</span>
                    <input type="text" name="usuario" class="input-login">
                </label>

                <label>
                    <span class="label-input">Senha:</span>
                    <input type="text" name="senha" class="input-login">
                </label>

                <button id="button-login" class="default-button" type="submit">Login</button>

                <?php

                // Se login vazio
                if (isset($_SESSION["emptyLogin"])) {
                    echo $_SESSION["emptyLogin"];
                    unset($_SESSION["emptyLogin"]);
                }

                // Se login inválido
                if (isset($_SESSION["loginError"])) {
                    echo $_SESSION["loginError"];
                    unset($_SESSION["loginError"]);
                }

                // Se login não autorizado
                if (isset($_SESSION["notAuth"])) {
                    echo $_SESSION["notAuth"];
                    unset($_SESSION["notAuth"]);
                }

                // Se sair da conta
                if (isset($_SESSION["logOff"])) {
                    echo $_SESSION["logOff"];
                    unset($_SESSION["logOff"]);
                }

                ?>

                <span class="copyright-text">&copy; Gamebit 2026</span>

                <a href="<?= $finalURL ?>/index.php" class="default-button" style="text-align: center; margin-top: 1rem; padding: 0.5rem; background-color: #3D3D3D;">Página inicial</a>
            </form>
        </div>
    </main>

    <!-- JQUERY CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>