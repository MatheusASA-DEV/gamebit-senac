<?php

// Verificando se existe um usuário logado para permitir acesso a esta página
include_once __DIR__ . "/../UsuarioComum.php";

require_once __DIR__ . "/../../connection/connection.php";
require_once __DIR__ . "/Produto.php";
require_once __DIR__ . "/RepositorioProduto.php";

// Input Hidden
$insertRequest = $_POST["cadastrar"] ?? null;

if (isset($insertRequest) && $insertRequest == "true") {
    // Variáveis para armazenar o valor dos inputs para posteriormente inserir no banco
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
    $desconto = $_POST["produto_desconto"] != "" ? (float) $_POST["produto_desconto"] : null;
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
        $marca
    );

    $repos = new RepositorioProduto($pdo);

    try {
        $repos->Cadastrar($produto);
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
            <p class="message-body">Não foi possível concluir o cadastro. <br> Detalhes: ' . $e->getMessage() . '</p>
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
                    <i class="fa-solid fa-boxes-stacked icon-section"></i>
                    <h2 class="section-title">Cadastrar produtos</h2>
                </div>

                <div class="form-container">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-section">
                            <h2 class="form-section-title">Upload de imagens</h2>

                            <div id="upload-container">
                                <div id="upload-area">
                                    <i class="fa-solid fa-file-circle-plus icon-upload"></i>
                                    <span id="upload-text">Selecione ou solte arquivos aqui</span>

                                    <input type="file" name="produto_imagens[]" id="upload-image-input" accept="image/png, image/jpg, image/jpeg, image/webp" multiple hidden>
                                </div>

                                <div id="upload-view">
                                    <div id="upload-row-wrapper"></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <h2 class="form-section-title">Informações gerais</h2>

                            <div class="inputs-wrapper">
                                <label class="input-label">
                                    <p class="label-name">Status</p>

                                    <select name="produto_status" disabled>
                                        <option value="1" class="form-option" selected>Ativo</option>
                                        <option value="0" class="form-option">Inativo</option>
                                    </select>
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Nome</p>
                                    <input type="text" name="produto_nome" class="form-input" placeholder="Nome do produto" required>
                                </label>

                                <!-- Seleção de Categoria -->
                                <label class="input-label">
                                    <p class="label-name">Categoria</p>

                                    <select name="produto_categoria" id="categoria-select" required>
                                        <option value="" class="form-option">Selecionar...</option>

                                        <?php

                                        $sql = "SELECT id_categoria, nome FROM categoria WHERE status = 1";
                                        $stmt = $pdo->prepare($sql);
                                        $stmt->execute();
                                        $res = $stmt->fetchAll();

                                        foreach ($res as $categoria) {
                                            echo
                                            '
                                            <option value="' . $categoria["id_categoria"] . '" class="form-option">' . $categoria["nome"] . '</option>
                                            ';
                                        }

                                        ?>
                                    </select>
                                </label>

                                <label class="input-label" style="flex-basis: 100%;">
                                    <p class="label-name">Descrição</p>

                                    <textarea name="produto_descricao" class="form-input" placeholder="Descreva o produto" style="min-height: 100px; max-height: 140px; resize: none;"></textarea>
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
                                        $res = $stmt->fetchAll();

                                        foreach ($res as $marca) {
                                            echo
                                            '
                                            <option value="' . $marca["id_marca"] . '" class="form-option">' . $marca["nome"] . '</option>
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

                                        <option value="127V" class="form-option">127V</option>
                                        <option value="220V" class="form-option">220V</option>
                                        <option value="Bi-volt" class="form-option">Bi-volt</option>
                                    </select>
                                </label>

                                <!-- Seleção de Leitor de Discos -->
                                <label class="input-label">
                                    <p class="label-name">Leitor de Discos</p>

                                    <select name="produto_leitor">
                                        <option value="" class="form-option">Selecionar...</option>

                                        <option value="1" class="form-option">Sim</option>
                                        <option value="0" class="form-option">Não</option>
                                    </select>
                                </label>

                                <!-- Seleção de Cores -->
                                <label class="input-label">
                                    <p class="label-name">Cor</p>

                                    <select name="produto_cor">
                                        <option value="" class="form-option">Selecionar...</option>

                                        <option value="Branco" class="form-option">Branco</option>
                                        <option value="Preto" class="form-option">Preto</option>
                                        <option value="Verde" class="form-option">Verde</option>
                                        <option value="Vermelho" class="form-option">Vermelho</option>
                                        <option value="Cinza" class="form-option">Cinza</option>
                                        <option value="Prateado" class="form-option">Prateado</option>
                                    </select>
                                </label>

                                <!-- Seleção de Armazenamento -->
                                <label class="input-label">
                                    <p class="label-name">Armazenamento</p>

                                    <select name="produto_armazenamento">
                                        <option value="" class="form-option">Selecionar...</option>

                                        <option value="128GB" class="form-option">128GB</option>
                                        <option value="256GB" class="form-option">256GB</option>
                                        <option value="512GB" class="form-option">512GB</option>
                                        <option value="1TB" class="form-option">1TB</option>
                                        <option value="2TB" class="form-option">2TB</option>
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
                                        $res = $stmt->fetchAll();

                                        foreach ($res as $plataforma) {
                                            echo
                                            '
                                            <option value="' . $plataforma["id_plataforma"] . '" class="form-option">' . $plataforma["nome"] . '</option>
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
                                        $res = $stmt->fetchAll();

                                        foreach ($res as $genero) {
                                            echo
                                            '
                                            <option value="' . $genero["id_genero"] . '" class="form-option">' . $genero["nome"] . '</option>
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
                                        $res = $stmt->fetchAll();

                                        foreach ($res as $desenvolvedor) {
                                            echo
                                            '
                                            <option value="' . $desenvolvedor["id_desenvolvedor"] . '" class="form-option">' . $desenvolvedor["nome"] . '</option>
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

                                        <option value="Intel Core i5-8400" class="form-option">Intel Core i5-8400</option>
                                        <option value="AMD Ryzen 5 2600" class="form-option">AMD Ryzen 5 2600</option>
                                        <option value="Intel Core i5-10400F" class="form-option">Intel Core i5-10400F</option>
                                        <option value="AMD Ryzen 5 3600" class="form-option">AMD Ryzen 5 3600</option>
                                        <option value="Intel Core i5-12400F" class="form-option">Intel Core i5-12400F</option>
                                        <option value="AMD Ryzen 5 5600" class="form-option">AMD Ryzen 5 5600</option>
                                        <option value="Intel Core i5-13400F" class="form-option">Intel Core i5-13400F</option>
                                        <option value="AMD Ryzen 7 5800X3D" class="form-option">AMD Ryzen 7 5800X3D</option>
                                        <option value="Intel Core i7-13700K" class="form-option">Intel Core i7-13700K</option>
                                        <option value="AMD Ryzen 7 7800X3D" class="form-option">AMD Ryzen 7 7800X3D</option>
                                    </select>
                                </label>

                                <!-- GPU -->
                                <label class="input-label">
                                    <p class="label-name">Placa de vídeo mínimo</p>

                                    <select name="produto_gpu">
                                        <option value="" class="form-option">Selecionar...</option>

                                        <option value="NVIDIA GeForce GTX 1060" class="form-option">NVIDIA GeForce GTX 1060</option>
                                        <option value="AMD Radeon RX 580" class="form-option">AMD Radeon RX 580</option>
                                        <option value="NVIDIA GeForce GTX 1660 Super" class="form-option">NVIDIA GeForce GTX 1660 Super</option>
                                        <option value="AMD Radeon RX 5600 XT" class="form-option">AMD Radeon RX 5600 XT</option>
                                        <option value="NVIDIA GeForce RTX 3060" class="form-option">NVIDIA GeForce RTX 3060</option>
                                        <option value="AMD Radeon RX 6600" class="form-option">AMD Radeon RX 6600</option>
                                        <option value="NVIDIA GeForce RTX 4060" class="form-option">NVIDIA GeForce RTX 4060</option>
                                        <option value="AMD Radeon RX 7600" class="form-option">AMD Radeon RX 7600</option>
                                        <option value="NVIDIA GeForce RTX 4070" class="form-option">NVIDIA GeForce RTX 4070</option>
                                        <option value="AMD Radeon RX 7800 XT" class="form-option">AMD Radeon RX 7800 XT</option>
                                    </select>
                                </label>

                                <!-- RAM -->
                                <label class="input-label">
                                    <p class="label-name">Memória RAM mínima</p>

                                    <select name="produto_ram">
                                        <option value="" class="form-option">Selecionar...</option>

                                        <option value="4GB" class="form-option">4GB</option>
                                        <option value="6GB" class="form-option">6GB</option>
                                        <option value="8GB" class="form-option">8GB</option>
                                        <option value="12GB" class="form-option">12GB</option>
                                        <option value="16GB" class="form-option">16GB</option>
                                        <option value="24GB" class="form-option">24GB</option>
                                        <option value="32GB" class="form-option">32GB</option>
                                    </select>
                                </label>

                                <!-- SO -->
                                <label class="input-label">
                                    <p class="label-name">Sistema Operacional mínimo</p>

                                    <select name="produto_so">
                                        <option value="" class="form-option">Selecionar...</option>

                                        <option value="Windows 7" class="form-option">Windows 7</option>
                                        <option value="Windows 10" class="form-option">Windows 10</option>
                                        <option value="Windows 11" class="form-option">Windows 11</option>
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
                                    <input type="text" name="produto_custo" id="custo-input" class="form-input" placeholder="Custo" data-mask="00000.00" data-mask-reverse="true" required>
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Lucro (%)</p>
                                    <input type="text" min="0" name="produto_lucro" id="lucro-input" class="form-input" placeholder="Lucro" data-mask="000.00%" data-mask-reverse="true" required disabled>
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Em promoção</p>

                                    <select name="produto_status_promocao" id="in-promo-select" disabled required>
                                        <option value="0" class="form-option" selected>Não</option>
                                        <option value="1" class="form-option">Sim</option>
                                    </select>
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Desconto (%)</p>
                                    <input type="text" min="0" name="produto_desconto" id="desconto-input" class="form-input" placeholder="Desconto" data-mask="000.00%" data-mask-reverse="true" disabled>
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Preço de Venda</p>
                                    <input type="text" min="0" name="produto_venda" id="venda-input" class="form-input" placeholder="Preço de Venda" data-mask="00000.00" data-mask-reverse="true" readonly>
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Preço na Promoção</p>
                                    <input type="text" min="0" name="produto_promocao" id="promocao-input" class="form-input" placeholder="Preço na Promoção" data-mask="00000.00" data-mask-reverse="true" readonly>
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Estoque disponível</p>
                                    <input type="number" min="0" name="produto_estoque" id="estoque-input" class="form-input" placeholder="Estoque" maxlength="5" required>
                                </label>
                            </div>
                        </div>

                        <input type="hidden" name="cadastrar" value="true">

                        <button type="submit" id="submit-form-btn" class="default-button dashboard-button">Cadastrar</button>
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
    <script src="../../custom/js/form-handle-product.js"></script>

    <!-- JQUERY -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="../../assets/js/jquery.mask.min.js"></script>
</body>

</html>