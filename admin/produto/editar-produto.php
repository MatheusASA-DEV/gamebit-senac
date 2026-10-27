<?php

// Verificando se existe um usuário logado para permitir acesso a esta página
include_once __DIR__ . "/../UsuarioComum.php";

require_once __DIR__ . "/../../connection/connection.php";
require_once __DIR__ . "/../../config/config.php";
require_once __DIR__ . "/Produto.php";
require_once __DIR__ . "/RepositorioProduto.php";

// Pega da URL o ID passado pelo filtrar-produto.php
$selectedIdProduto = $_GET["id_produto"] ?? null;

// Input Hidden
$insertRequest = $_POST["atualizar"] ?? null;

// Repositório de CRUD do Produto
$repos = new RepositorioProduto($pdo);

if (isset($insertRequest) && $insertRequest == "true") {
    // Variáveis para armazenar o valor dos inputs para posteriormente inserir no banco
    $id = $_POST["id"];
    $status = $_POST["produto_status"];
    $nome = $_POST["produto_nome"];
    $estoque = $_POST["produto_estoque"];
    $cpu = $_POST["produto_cpu"] != "" ? $_POST["produto_cpu"] : null;
    $gpu = $_POST["produto_gpu"] != "" ? $_POST["produto_gpu"] : null;
    $so = $_POST["produto_so"] != "" ? $_POST["produto_so"] : null;
    $ram = $_POST["produto_ram"] != "" ? $_POST["produto_ram"] : null;
    $custo = (float) $_POST["produto_custo"];
    $lucro = (float) $_POST["produto_lucro"];

    // Erro de string given
    $categoria = (float) $_POST["produto_categoria"];

    $desenvolvedor = $_POST["produto_desenvolvedor"] != ""
        ? $_POST["produto_desenvolvedor"]
        : null;

    $plataforma = $_POST["produto_plataforma"] != ""
        ? $_POST["produto_plataforma"]
        : null;

    $genero = $_POST["produto_genero"] != ""
        ? $_POST["produto_genero"]
        : null;

    $marca = $_POST["produto_marca"] != ""
        ? $_POST["produto_marca"]
        : null;

    $venda = (float) $_POST["produto_venda"];
    $status_promocao = $_POST["produto_status_promocao"] ?? 0;
    $desconto = (float) $_POST["produto_desconto"] ?? null;
    $promocao = $_POST["produto_promocao"] != "" ? $_POST["produto_promocao"] : null;
    $descricao = $_POST["produto_descricao"];
    $armazenamento = $_POST["produto_armazenamento"] != "" ? $_POST["produto_armazenamento"] : null;
    $leitor = $_POST["produto_leitor"] == "1" ? 1 : 0;
    $voltagem = $_POST["produto_voltagem"];
    $cor = $_POST["produto_cor"];

    $imagem1 = basename($_FILES["produto_imagens"]["name"][0]);
    $temp = $_FILES["produto_imagens"]["tmp_name"][0];
    $finalPath = "../../images/produtos/" . $imagem1;
    move_uploaded_file($temp, $finalPath);

    $imagem2 = basename($_FILES["produto_imagens"]["name"][1]);
    $temp = $_FILES["produto_imagens"]["tmp_name"][1];
    $finalPath = "../../images/produtos/" . $imagem2;
    move_uploaded_file($temp, $finalPath);

    $imagem3 = basename($_FILES["produto_imagens"]["name"][2]);
    $temp = $_FILES["produto_imagens"]["tmp_name"][2];
    $finalPath = "../../images/produtos/" . $imagem3;
    move_uploaded_file($temp, $finalPath);

    $imagem4 = basename($_FILES["produto_imagens"]["name"][3]);
    $temp = $_FILES["produto_imagens"]["tmp_name"][3];
    $finalPath = "../../images/produtos/" . $imagem4;
    move_uploaded_file($temp, $finalPath);

    $produto = new Produto(
        $nome,
        $estoque,
        $custo,
        $lucro,
        $venda,
        $imagem1,
        $categoria,
        $status_promocao,
        $desconto,
        $cpu,
        $gpu,
        $ram,
        $so,
        $descricao,
        $promocao,
        $imagem2,
        $imagem3,
        $imagem4,
        $cor,
        $armazenamento,
        $leitor,
        $voltagem,
        $desenvolvedor,
        $plataforma,
        $genero,
        $marca,
        $status,
        $id
    );

    $repos = new RepositorioProduto($pdo);

    try {
        $repos->Atualizar($produto);
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
            <p class="message-body">Não foi possível atualizar o cadastro. <br> Detalhes: ' . $e->getMessage() . '</p>
        </div>
        ';
    } finally {
        header("Location: consultar-produto.php");
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
                    <i class="fa-solid fa-pen icon-section"></i>
                    <h2 class="section-title">Editar produto</h2>
                </div>

                <div class="form-container">
                    <?php

                    try {
                        $res = $repos->Consultar($selectedIdProduto);
                    } catch (Exception $e) {
                        exit("Erro: " . $e->getMessage());
                    }

                    ?>

                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-section">
                            <h2 class="form-section-title">Remover ou atualizar imagens do produto</h2>

                            <div id="upload-container">
                                <div id="upload-area">
                                    <i class="fa-solid fa-file-circle-plus icon-upload"></i>
                                    <span id="upload-text">Selecione ou solte arquivos aqui</span>

                                    <input type="file" name="produto_imagens[]" id="upload-image-input" accept="image/png, image/jpg, image/jpeg, image/webp" multiple hidden>
                                </div>

                                <div id="upload-view">
                                    <div id="upload-row-wrapper">
                                        <?php if ($res["imagem_principal"] != ""): ?>
                                        <div class="upload-row">
                                            <div class="upload-image-container"><img src="<?= $finalURL ?>/images/produtos/<?= $res["imagem_principal"] ?>" alt="" class="upload-image"></div>
    
                                            <div class="upload-details">
                                                <p class="upload-title"><?= $res["imagem_principal"] ?></p>
    
                                                <span class="upload-progress-text">Salvo</span>
                                            </div>
    
                                            <button type="button" class="upload-delete-button remove-upload" title="Remover upload"><i class="fa-solid fa-trash-can icon-upload-delete"></i></button>
                                        </div>
                                        <?php endif ?>

                                        <?php if ($res["imagem_2"] != ""): ?>
                                        <div class="upload-row">
                                            <div class="upload-image-container"><img src="<?= $finalURL ?>/images/produtos/<?= $res["imagem_2"] ?>" alt="" class="upload-image"></div>
    
                                            <div class="upload-details">
                                                <p class="upload-title"><?= $res["imagem_2"] ?></p>
    
                                                <span class="upload-progress-text">Salvo</span>
                                            </div>
    
                                            <button type="button" class="upload-delete-button remove-upload" title="Remover upload"><i class="fa-solid fa-trash-can icon-upload-delete"></i></button>
                                        </div>
                                        <?php endif ?>

                                        <?php if ($res["imagem_3"] != ""): ?>
                                        <div class="upload-row">
                                            <div class="upload-image-container"><img src="<?= $finalURL ?>/images/produtos/<?= $res["imagem_3"] ?>" alt="" class="upload-image"></div>
    
                                            <div class="upload-details">
                                                <p class="upload-title"><?= $res["imagem_3"] ?></p>
    
                                                <span class="upload-progress-text">Salvo</span>
                                            </div>
    
                                            <button type="button" class="upload-delete-button remove-upload" title="Remover upload"><i class="fa-solid fa-trash-can icon-upload-delete"></i></button>
                                        </div>
                                        <?php endif ?>

                                        <?php if ($res["imagem_4"] != ""): ?>
                                        <div class="upload-row">
                                            <div class="upload-image-container"><img src="<?= $finalURL ?>/images/produtos/<?= $res["imagem_4"] ?>" alt="" class="upload-image"></div>
    
                                            <div class="upload-details">
                                                <p class="upload-title"><?= $res["imagem_4"] ?></p>
    
                                                <span class="upload-progress-text">Salvo</span>
                                            </div>
    
                                            <button type="button" class="upload-delete-button remove-upload" title="Excluir do banco de dados"><i class="fa-solid fa-trash-can icon-upload-delete"></i></button>
                                        </div>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <h2 class="form-section-title">Informações gerais</h2>

                            <div class="inputs-wrapper">
                                <label class="input-label">
                                    <p class="label-name">Status</p>

                                    <select name="produto_status">
                                        <option value="1" class="form-option" <?= $res["status"] == 1 ? "selected" : "" ?>>Ativo</option>
                                        <option value="0" class="form-option" <?= $res["status"] == 0 ? "selected" : "" ?>>Inativo</option>
                                    </select>
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Nome</p>
                                    <input type="text" name="produto_nome" class="form-input" placeholder="Nome do produto" value="<?= $res["nome"] ?>">
                                </label>

                                <!-- Seleção de Categoria -->
                                <label class="input-label">
                                    <p class="label-name">Categoria</p>

                                    <select name="produto_categoria" id="categoria-select">
                                        <?php

                                        $sql = "SELECT id_categoria, nome FROM categoria WHERE status = 1";
                                        $stmt = $pdo->prepare($sql);
                                        $stmt->execute();
                                        $categorias = $stmt->fetchAll();

                                        foreach ($categorias as $categoria) {
                                            echo
                                            '
                                            <option value="' . $categoria["id_categoria"] . '" class="form-option" ' . ($res["id_categoria"] == $categoria["id_categoria"] ? "selected" : "") . '>' . $categoria["nome"] . '</option>
                                            ';
                                        }

                                        ?>
                                    </select>
                                </label>

                                <label class="input-label" style="flex-basis: 100%;">
                                    <p class="label-name">Descrição</p>

                                    <textarea name="produto_descricao" class="form-input" placeholder="Descreva o produto" style="min-height: 100px; max-height: 140px; resize: none;"><?= $res["descricao"] ?></textarea>
                                </label>
                            </div>
                        </div>

                        <!-- Consoles -->
                        <div class="form-section" id="console-section" hidden>
                            <h2 class="form-section-title">Características (Consoles)</h2>

                            <div class="inputs-wrapper">
                                <!-- Seleção de Marcas -->
                                <label class="input-label">
                                    <p class="label-name">Marca</p>

                                    <select name="produto_marca">
                                        <option value="" class="form-option">Selecionar...</option>

                                        <?php

                                        $sql = "SELECT id_marca, nome FROM marca WHERE status = 1";
                                        $stmt = $pdo->prepare($sql);
                                        $stmt->execute();
                                        $marcas = $stmt->fetchAll();

                                        foreach ($marcas as $marca) {
                                            echo
                                            '
                                            <option value="' . $marca["id_marca"] . '" class="form-option" ' . ($res["id_marca"] == $marca["id_marca"] ? "selected" : "") . '>' . $marca["nome"] . '</option>
                                            ';
                                        }

                                        ?>
                                    </select>
                                </label>

                                <!-- Seleção de Voltagem -->
                                <label class="input-label">
                                    <p class="label-name">Voltagem</p>

                                    <select name="produto_voltagem">
                                        <option value="" class="form-option">Selecionar...</option>

                                        <option value="127V" class="form-option" <?= $res["voltagem"] == "127V" ? "selected" : "" ?>>127V</option>
                                        <option value="220V" class="form-option" <?= $res["voltagem"] == "220V" ? "selected" : "" ?>>220V</option>
                                        <option value="Bi-volt" class="form-option" <?= $res["voltagem"] == "Bi-volt" ? "selected" : "" ?>>Bi-volt</option>
                                    </select>
                                </label>

                                <!-- Seleção de Leitor de Discos -->
                                <label class="input-label">
                                    <p class="label-name">Leitor de Discos</p>

                                    <select name="produto_leitor">
                                        <option value="" class="form-option">Selecionar...</option>

                                        <option value="1" class="form-option" <?= $res["leitor"] == 1 ? "selected" : "" ?>>Sim</option>
                                        <option value="0" class="form-option" <?= $res["leitor"] == 0 ? "selected" : "" ?>>Não</option>
                                    </select>
                                </label>

                                <!-- Seleção de Cores -->
                                <label class="input-label">
                                    <p class="label-name">Cor</p>

                                    <select name="produto_cor">
                                        <option value="" class="form-option">Selecionar...</option>

                                        <option value="Branco" class="form-option" <?= $res["cor"] == "Branco" ? "selected" : "" ?>>Branco</option>
                                        <option value="Preto" class="form-option" <?= $res["cor"] == "Preto" ? "selected" : "" ?>>Preto</option>
                                        <option value="Verde" class="form-option" <?= $res["cor"] == "Verde" ? "selected" : "" ?>>Verde</option>
                                        <option value="Vermelho" class="form-option" <?= $res["cor"] == "Vermelho" ? "selected" : "" ?>>Vermelho</option>
                                        <option value="Cinza" class="form-option" <?= $res["cor"] == "Cinza" ? "selected" : "" ?>>Cinza</option>
                                        <option value="Prateado" class="form-option" <?= $res["cor"] == "Prateado" ? "selected" : "" ?>>Prateado</option>
                                    </select>
                                </label>

                                <!-- Seleção de Armazenamento -->
                                <label class="input-label">
                                    <p class="label-name">Armazenamento</p>

                                    <select name="produto_armazenamento">
                                        <option value="" class="form-option">Selecionar...</option>

                                        <option value="128GB" class="form-option" <?= $res["armazenamento"] == "128GB" ? "selected" : "" ?>>128GB</option>
                                        <option value="256GB" class="form-option" <?= $res["armazenamento"] == "256GB" ? "selected" : "" ?>>256GB</option>
                                        <option value="512GB" class="form-option" <?= $res["armazenamento"] == "512GB" ? "selected" : "" ?>>512GB</option>
                                        <option value="1TB" class="form-option" <?= $res["armazenamento"] == "1TB" ? "selected" : "" ?>>1TB</option>
                                        <option value="2TB" class="form-option" <?= $res["armazenamento"] == "2TB" ? "selected" : "" ?>>2TB</option>
                                    </select>
                                </label>
                            </div>
                        </div>

                        <!-- Jogos -->
                        <div class="form-section" id="jogo-section" hidden>
                            <h2 class="form-section-title">Características (Jogos)</h2>

                            <div class="inputs-wrapper">
                                <!-- Seleção de Plataformas -->
                                <label class="input-label">
                                    <p class="label-name">Plataforma</p>

                                    <select name="produto_plataforma">
                                        <option value="" class="form-option">Selecionar...</option>

                                        <?php

                                        $sql = "SELECT id_plataforma, nome FROM plataforma WHERE status = 1";
                                        $stmt = $pdo->prepare($sql);
                                        $stmt->execute();
                                        $plataformas = $stmt->fetchAll();

                                        foreach ($plataformas as $plataforma) {
                                            echo
                                            '
                                            <option value="' . $plataforma["id_plataforma"] . '" class="form-option" ' . ($res["id_plataforma"] == $plataforma["id_plataforma"] ? "selected" : "") . '>' . $plataforma["nome"] . '</option>
                                            ';
                                        }

                                        ?>
                                    </select>
                                </label>

                                <!-- Seleção de Genêro de Jogos -->
                                <label class="input-label">
                                    <p class="label-name">Genêro de Jogo</p>

                                    <select name="produto_genero">
                                        <option value="" class="form-option">Selecionar...</option>

                                        <?php

                                        $sql = "SELECT id_genero, nome FROM genero_jogo WHERE status = 1";
                                        $stmt = $pdo->prepare($sql);
                                        $stmt->execute();
                                        $generos = $stmt->fetchAll();

                                        foreach ($generos as $genero) {
                                            echo
                                            '
                                            <option value="' . $genero["id_genero"] . '" class="form-option" ' . ($res["id_genero"] == $genero["id_genero"] ? "selected" : "") . '>' . $genero["nome"] . '</option>
                                            ';
                                        }

                                        ?>
                                    </select>
                                </label>

                                <!-- Seleção de Desenvolvedor -->
                                <label class="input-label">
                                    <p class="label-name">Desenvolvedor</p>

                                    <select name="produto_desenvolvedor">
                                        <option value="" class="form-option">Selecionar...</option>

                                        <?php

                                        $sql = "SELECT id_desenvolvedor, nome FROM desenvolvedor WHERE status = 1";
                                        $stmt = $pdo->prepare($sql);
                                        $stmt->execute();
                                        $devs = $stmt->fetchAll();

                                        foreach ($devs as $desenvolvedor) {
                                            echo
                                            '
                                            <option value="' . $desenvolvedor["id_desenvolvedor"] . '" class="form-option" ' . ($res["id_desenvolvedor"] == $desenvolvedor["id_desenvolvedor"] ? "selected" : "") . '>' . $desenvolvedor["nome"] . '</option>
                                            ';
                                        }

                                        ?>
                                    </select>
                                </label>
                            </div>

                            <div class="inputs-wrapper" style="margin-top: 1rem;">
                                <!-- CPU -->
                                <label class="input-label">
                                    <p class="label-name">Processador mínimo</p>

                                    <select name="produto_cpu">
                                        <option value="" class="form-option">Selecionar...</option>

                                        <option value="Intel Core i5-8400" class="form-option" <?= $res["cpu_min"] == "Intel Core i5-8400" ? "selected" : "" ?>>Intel Core i5-8400</option>
                                        <option value="AMD Ryzen 5 2600" class="form-option" <?= $res["cpu_min"] == "AMD Ryzen 5 2600" ? "selected" : "" ?>>AMD Ryzen 5 2600</option>
                                        <option value="Intel Core i5-10400F" class="form-option" <?= $res["cpu_min"] == "Intel Core i5-10400F" ? "selected" : "" ?>>Intel Core i5-10400F</option>
                                        <option value="AMD Ryzen 5 3600" class="form-option" <?= $res["cpu_min"] == "AMD Ryzen 5 3600" ? "selected" : "" ?>>AMD Ryzen 5 3600</option>
                                        <option value="Intel Core i5-12400F" class="form-option" <?= $res["cpu_min"] == "Intel Core i5-12400F" ? "selected" : "" ?>>Intel Core i5-12400F</option>
                                        <option value="AMD Ryzen 5 5600" class="form-option" <?= $res["cpu_min"] == "AMD Ryzen 5 5600" ? "selected" : "" ?>>AMD Ryzen 5 5600</option>
                                        <option value="Intel Core i5-13400F" class="form-option" <?= $res["cpu_min"] == "Intel Core i5-13400F" ? "selected" : "" ?>>Intel Core i5-13400F</option>
                                        <option value="AMD Ryzen 7 5800X3D" class="form-option" <?= $res["cpu_min"] == "AMD Ryzen 7 5800X3D" ? "selected" : "" ?>>AMD Ryzen 7 5800X3D</option>
                                        <option value="Intel Core i7-13700K" class="form-option" <?= $res["cpu_min"] == "Intel Core i7-13700K" ? "selected" : "" ?>>Intel Core i7-13700K</option>
                                        <option value="AMD Ryzen 7 7800X3D" class="form-option" <?= $res["cpu_min"] == "AMD Ryzen 7 7800X3D" ? "selected" : "" ?>>AMD Ryzen 7 7800X3D</option>
                                    </select>
                                </label>

                                <!-- GPU -->
                                <label class="input-label">
                                    <p class="label-name">Placa de vídeo mínimo</p>

                                    <select name="produto_gpu">
                                        <option value="" class="form-option">Selecionar...</option>

                                        <option value="NVIDIA GeForce GTX 1060" class="form-option" <?= $res["gpu_min"] == "NVIDIA GeForce GTX 1060" ? "selected" : "" ?>>NVIDIA GeForce GTX 1060</option>
                                        <option value="AMD Radeon RX 580" class="form-option" <?= $res["gpu_min"] == "AMD Radeon RX 580" ? "selected" : "" ?>>AMD Radeon RX 580</option>
                                        <option value="NVIDIA GeForce GTX 1660 Super" class="form-option" <?= $res["gpu_min"] == "VIDIA GeForce GTX 1660 Super" ? "selected" : "" ?>>NVIDIA GeForce GTX 1660 Super</option>
                                        <option value="AMD Radeon RX 5600 XT" class="form-option" <?= $res["gpu_min"] == "AMD Radeon RX 5600 XT" ? "selected" : "" ?>>AMD Radeon RX 5600 XT</option>
                                        <option value="NVIDIA GeForce RTX 3060" class="form-option" <?= $res["gpu_min"] == "NVIDIA GeForce RTX 3060" ? "selected" : "" ?>>NVIDIA GeForce RTX 3060</option>
                                        <option value="AMD Radeon RX 6600" class="form-option" <?= $res["gpu_min"] == "AMD Radeon RX 6600" ? "selected" : "" ?>>AMD Radeon RX 6600</option>
                                        <option value="NVIDIA GeForce RTX 4060" class="form-option" <?= $res["gpu_min"] == "NVIDIA GeForce RTX 4060" ? "selected" : "" ?>>NVIDIA GeForce RTX 4060</option>
                                        <option value="AMD Radeon RX 7600" class="form-option" <?= $res["gpu_min"] == "AMD Radeon RX 7600" ? "selected" : "" ?>>AMD Radeon RX 7600</option>
                                        <option value="NVIDIA GeForce RTX 4070" class="form-option" <?= $res["gpu_min"] == "NVIDIA GeForce RTX 4070" ? "selected" : "" ?>>NVIDIA GeForce RTX 4070</option>
                                        <option value="AMD Radeon RX 7800 XT" class="form-option" <?= $res["gpu_min"] == "AMD Radeon RX 7800 XT" ? "selected" : "" ?>>AMD Radeon RX 7800 XT</option>
                                    </select>
                                </label>

                                <!-- RAM -->
                                <label class="input-label">
                                    <p class="label-name">Memória RAM mínima</p>

                                    <select name="produto_ram">
                                        <option value="" class="form-option">Selecionar...</option>

                                        <option value="4GB" class="form-option" <?= $res["ram_min"] == "4GB" ? "selected" : "" ?>>4 GB</option>
                                        <option value="6GB" class="form-option" <?= $res["ram_min"] == "6GB" ? "selected" : "" ?>>6 GB</option>
                                        <option value="8GB" class="form-option" <?= $res["ram_min"] == "8GB" ? "selected" : "" ?>>8 GB</option>
                                        <option value="12GB" class="form-option" <?= $res["ram_min"] == "12GB" ? "selected" : "" ?>>12 GB</option>
                                        <option value="16GB" class="form-option" <?= $res["ram_min"] == "16GB" ? "selected" : "" ?>>16 GB</option>
                                        <option value="24GB" class="form-option" <?= $res["ram_min"] == "24GB" ? "selected" : "" ?>>24 GB</option>
                                        <option value="32GB" class="form-option" <?= $res["ram_min"] == "32GB" ? "selected" : "" ?>>32 GB</option>
                                    </select>
                                </label>

                                <!-- SO -->
                                <label class="input-label">
                                    <p class="label-name">Sistema Operacional mínimo</p>

                                    <select name="produto_so">
                                        <option value="" class="form-option">Selecionar...</option>

                                        <option value="Windows 7" class="form-option" <?= $res["so_min"] == "Windows 7" ? "selected" : "" ?>>Windows 7</option>
                                        <option value="Windows 10" class="form-option" <?= $res["so_min"] == "Windows 10" ? "selected" : "" ?>>Windows 10</option>
                                        <option value="Windows 11" class="form-option" <?= $res["so_min"] == "Windows 11" ? "selected" : "" ?>>Windows 11</option>
                                    </select>
                                </label>
                            </div>
                        </div>

                        <!-- Precificação -->
                        <div class="form-section">
                            <h2 class="form-section-title">Precificação</h2>

                            <div class="inputs-wrapper">
                                <label class="input-label">
                                    <p class="label-name">Custo</p>
                                    <input type="number" min="0" name="produto_custo" id="custo-input" class="form-input" value="<?= $res["preco_custo"] ?>" placeholder="Custo" data-mask="00000.00" data-mask-reverse="true" required>
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Lucro (%)</p>
                                    <input type="text" min="0" name="produto_lucro" id="lucro-input" class="form-input" value="<?= $res["lucro"] ?>" placeholder="Lucro" data-mask="000.00%" data-mask-reverse="true" required>
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Em promoção</p>

                                    <select name="produto_status_promocao" id="in-promo-select">
                                        <option value="0" class="form-option" <?= $res["status_promocao"] == 0 ? "selected" : "" ?>>Não</option>
                                        <option value="1" class="form-option" <?= $res["status_promocao"] == 1 ? "selected" : "" ?>>Sim</option>
                                    </select>
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Desconto (%)</p>
                                    <input type="text" min="0" name="produto_desconto" id="desconto-input" class="form-input" value="<?= $res["desconto"] ?>" placeholder="Desconto" data-mask="999.99%" data-mask-reverse="true" disabled>
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Preço de Venda</p>
                                    <input type="text" min="0" name="produto_venda" id="venda-input" class="form-input" value="<?= $res["preco_venda"] ?>" placeholder="Preço de Venda" data-mask="00000.00" data-mask-reverse="true" readonly>
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Preço na Promoção</p>
                                    <input type="text" min="0" name="produto_promocao" id="promocao-input" class="form-input" value="<?= $res["preco_promocao"] ?>" placeholder="Preço na Promoção" data-mask="00000.00" data-mask-reverse="true" readonly>
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Estoque disponível</p>
                                    <input type="number" min="0" name="produto_estoque" id="estoque-input" class="form-input" value="<?= $res["estoque"] ?>" placeholder="Estoque" maxlength="5" required>
                                </label>
                            </div>
                        </div>

                        <input type="hidden" name="atualizar" value="true">
                        <input type="hidden" name="id" value="<?= $selectedIdProduto ?>">

                        <button type="submit" class="default-button dashboard-button">Atualizar</button>
                    </form>
                </div>
            </section>
        </main>
    </div>

    <!-- Script Dashboard -->
    <script src="../../custom/js/dashboard.js"></script>
    <script src="../../custom/js/message-box.js"></script>
    <script src="../../custom/js/dashboard-product.js"></script>
    <script src="../../custom/js/upload-image.js"></script>
    <script src="../../custom/js/product-prices.js"></script>

    <!-- JQUERY -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="../../assets/js/jquery.mask.min.js"></script>
</body>

</html>