<?php

// Verificando se existe um usuário logado para permitir acesso a esta página
include_once __DIR__ . "/../UsuarioComum.php";

require_once __DIR__ . "/../../connection/connection.php";
require_once __DIR__ . "/Plataforma.php";
require_once __DIR__ . "/RepositorioPlataforma.php";

// Input Hidden
$insertRequest = $_POST["cadastrar"] ?? null;

if (isset($insertRequest) && $insertRequest == "true") {
    // Variáveis para armazenar o valor dos inputs para posteriormente inserir no banco
    $nome = $_POST["plataforma_nome"];

    $plataforma = new Plataforma($nome);

    $repos = new RepositorioPlataforma($pdo);

    try {
        $repos->Cadastrar($plataforma);
        $_SESSION["message"] =
        '
        <div class="message-box success shown">
            <h4 class="message-title">Feito!</h4>
            <p class="message-body">Cadastro realizado com sucesso.</p>
        </div>
        ';
    } catch (PDOException $e) {
        $_SESSION["message"] =
        '
        <div class="message-box fail shown">
            <h4 class="message-title">Erro!</h4>
            <p class="message-body">Não foi possível concluir o cadastro. <br> Detalhes: '. $e->getMessage() .'</p>
        </div>
        ';
    } finally {
        header("Location: consultar-plataforma.php");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta author="Matheus de Andrade Silva Arruda">
    <title>GameBit | Painel Administrativo</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=JetBrains+Mono:ital,wght@0,100..800;1,100..800&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css"
        integrity="sha512-QeR2VH+lsBE5LSAe1Q5EnTBbe7XTBubt8dG93Y7gidSgdMCr8nVqKcfKAMyN96SV8KDbZVTDXChatu5G2KQGzg=="
        crossorigin="anonymous" referrerpolicy="no-referrer">

    <!-- My Styles -->
    <link rel="stylesheet" href="../../custom/css/global.css">
    <link rel="stylesheet" href="../../custom/css/dashboard.css">
</head>

<body>
    <div id="dashboard-container">
        <?php include "../../components/DashboardSidebar.php" ?>

        <main>
            <?php require_once __DIR__ . "/../utils/message.php" ?>

            <section id="dashboard-content" class="dashboard-section">
                <div class="section-title-container">
                    <i class="fa-solid fa-desktop icon-section"></i>
                    <h2 class="section-title">Cadastrar plataformas</h2>
                </div>

                <div class="form-container">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-section">
                            <h2 class="form-section-title">Informações gerais</h2>

                            <div class="inputs-wrapper">
                                <label class="input-label">
                                    <p class="label-name">Status</p>

                                    <select name="plataforma_status" id="plataforma_status" disabled>
                                        <option value="1" class="form-option" selected>Ativo</option>
                                        <option value="0" class="form-option">Inativo</option>
                                    </select>
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Nome</p>
                                    <input type="text" name="plataforma_nome" id="plataforma_nome" class="form-input" placeholder="Nome do plataforma" required>
                                </label>
                            </div>
                        </div>

                        <input type="hidden" name="cadastrar" value="true">

                        <button type="submit" class="default-button dashboard-button">Cadastrar</button>
                    </form>
                </div>
            </section>
        </main>
    </div>

    <!-- Script Dashboard -->
    <script src="../../custom/js/dashboard.js"></script>
    <script src="../../custom/js/message-box.js"></script>
</body>

</html>