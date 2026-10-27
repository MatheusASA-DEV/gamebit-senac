<?php

// Verificando se existe um usuário logado para permitir acesso a esta página
include_once __DIR__ . "/../UsuarioComum.php";

require_once __DIR__ . "/../../connection/connection.php";
require_once __DIR__ . "/Categoria.php";
require_once __DIR__ . "/RepositorioCategoria.php";

// Pega da URL o ID passado pelo filtrar-categoria.php
$selectedIdCategoria = $_GET["id_categoria"] ?? null;

// Input Hidden
$insertRequest = $_POST["cadastrar"] ?? null;

// Repositório de CRUD da categoria
$repos = new RepositorioCategoria($pdo);

if (isset($insertRequest) && $insertRequest == "true") {
    // Variáveis para armazenar o valor dos inputs para posteriormente inserir no banco
    $status = $_POST["categoria_status"];
    $nome = $_POST["categoria_nome"];
    $observacao = $_POST["categoria_observacao"];
    $id = $_POST["id"];

    $categoria = new Categoria($nome, $status, $id);

    try {
        $repos->Atualizar($categoria);
        $_SESSION["message"] =
        '
        <div class="message-box success shown">
            <h4 class="message-title">Feito!</h4>
            <p class="message-body">Cadastro atualizado com sucesso.</p>
        </div>
        ';
    } catch (PDOException $e) {
        $_SESSION["message"] =
        '
        <div class="message-box fail shown">
            <h4 class="message-title">Erro!</h4>
            <p class="message-body">Não foi possível atualizar o cadastro. <br> Detalhes: '. $e->getMessage() .'</p>
        </div>
        ';
    } finally {
        header("Location: consultar-categoria.php");
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
                    <i class="fa-solid fa-file-pen icon-section"></i>
                    <h2 class="section-title">Editar categorias</h2>
                </div>

                <div class="form-container">
                    <?php 
                    
                    try {
                        $res = $repos->Consultar($selectedIdCategoria);
                    } catch (Exception $e) { exit("Erro: " . $e->getMessage()); }
                    
                    ?>

                    <form action="" method="post">
                        <div class="form-section">
                            <h2 class="form-section-title">Informações gerais</h2>

                            <div class="inputs-wrapper">
                                <label class="input-label">
                                    <p class="label-name">Status</p>

                                    <select name="categoria_status" id="categoria_status">
                                        <option value="1" class="form-option" <?= $res["status"] == 1 ? "selected" : "" ?>>Ativo</option>
                                        <option value="0" class="form-option" <?= $res["status"] == 0 ? "selected" : "" ?>>Inativo</option>
                                    </select>
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Nome</p>
                                    <input type="text" name="categoria_nome" id="categoria_nome" class="form-input" placeholder="Nome do categoria" value="<?= $res["nome"] ?>" required>
                                </label>
                            </div>
                        </div>

                        <input type="hidden" name="cadastrar" value="true">
                        <!-- Assim que entramos aqui, o PHP injeta o ID pego pelo GET e a memória é zerada, depois quando formos atualizar, esse input já tem o valor do ID e é passado via POST no momento em que clicamos em 'Atualizar' -->

                        <!-- Essa é a boa prática pois, ao clicar em editar, o PHP pega o ID via GET, a gente joga ele no input hidden e também pode buscar dados para auto-preencher campos e então, morre. Para atualizarmos (2ª requisição) precisamos ter acesso ao ID, e só temos acesso pois passamos para o input hidden quando a página carregou  -->
                        <input type="hidden" name="id" value="<?= $selectedIdCategoria ?>">

                        <button type="submit" class="default-button dashboard-button">Atualizar</button>
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