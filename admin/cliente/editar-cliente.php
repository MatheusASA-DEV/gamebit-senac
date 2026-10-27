<?php

// Verificando se existe um usuário logado para permitir acesso a esta página
include_once __DIR__ . "/../UsuarioComum.php";

require_once __DIR__ . "/../../connection/connection.php";
require_once __DIR__ . "/Cliente.php";
require_once __DIR__ . "/RepositorioCliente.php";

// Pega da URL o ID passado pelo filtrar-cliente.php
$selectedIdCliente = $_GET["id_cliente"] ?? null;

// Input Hidden
$insertRequest = $_POST["cadastrar"] ?? null;

// Repositório de CRUD do cliente
$repos = new RepositorioCliente($pdo);

if (isset($insertRequest) && $insertRequest == "true") {
    // Variáveis para armazenar o valor dos inputs para posteriormente inserir no banco
    $nome = $_POST["c_nome"];
    $rg = $_POST["c_rg"];
    $cpf = $_POST["c_cpf"];
    $endereco = $_POST["c_endereco"];
    $complemento = $_POST["c_complemento"];
    $cidade = $_POST["c_cidade"];
    $cep = $_POST["c_cep"];
    $numero = $_POST["c_numero"];
    $bairro = $_POST["c_bairro"];
    $estado = $_POST["c_estado"];
    $email = $_POST["c_email"];
    $senha = $_POST["c_senha"];
    $telefone = $_POST["c_residencial"];
    $celular = $_POST["c_celular"];
    $sexo = $_POST["c_sexo"];
    $nascimento = $_POST["c_nascimento"];
    $civil = $_POST["c_estado_civil"];
    $id = $_POST["c_id"];
    $status = $_POST["c_status"];

    $cliente = new Cliente(
        $nome,
        $rg,
        $cpf,
        $endereco,
        $complemento,
        $cidade,
        $cep,
        $numero,
        $bairro,
        $estado,
        $email,
        $senha,
        $telefone,
        $celular,
        $sexo,
        $nascimento,
        $civil,
        $id,
        $status
    );

    try {
        $repos->Atualizar($cliente);
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
            <p class="message-body">Não foi possível atualizar o cadastro. <br> Detalhes: ' . $e->getMessage() .'</p>
        </div>
        ';
    } finally {
        header("Location: consultar-cliente.php");
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
                    <i class="fa-solid fa-user-gear icon-section"></i>
                    <h2 class="section-title">Atualizar clientes</h2>
                </div>

                <div class="form-container">
                    <?php 
                    
                    try
                    {
                        $res = $repos->Consultar($selectedIdCliente);
                    }
                    catch (Exception $e)
                    {
                        exit("Erro: " . $e->getMessage());
                    }
                    
                    ?>

                    <form action="" method="post">
                        <div class="form-section">
                            <h2 class="form-section-title">Informações gerais</h2>

                            <div class="inputs-wrapper">
                                <label class="input-label">
                                    <p class="label-name">Status</p>

                                    <select name="c_status">
                                        <option value="1" class="form-option" <?= $res["status"] == 1 ? "selected" : "" ?>>Ativo</option>
                                        <option value="0" class="form-option" <?= $res["status"] == 0 ? "selected" : "" ?>>Inativo</option>
                                    </select>
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Nome</p>
                                    <input type="text" name="c_nome" class="form-input" placeholder="Nome completo" value="<?= $res["nome"] ?>">
                                </label>

                                <label class="input-label">
                                    <p class="label-name">CPF</p>
                                    <input type="text" name="c_cpf" class="form-input" placeholder="000.000.000-00" value="<?= $res["cpf"] ?>" required>
                                </label>

                                <label class="input-label">
                                    <p class="label-name">RG</p>
                                    <input type="text" name="c_rg" class="form-input" placeholder="00.000.000-A" value="<?= $res["rg"] ?>">
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Telefone Residencial</p>
                                    <input type="tel" name="c_residencial" class="form-input"
                                        placeholder="Telefone residencial" data-mask="(00) 0000-0000" value="<?= $res["telefone_residencial"] ?>">
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Telefone Celular</p>
                                    <input type="tel" name="c_celular" class="form-input"
                                        placeholder="Telefone celular" data-mask="(00) 00000-0000" value="<?= $res["telefone_celular"] ?>">
                                </label>

                                <label class="input-label">
									<p class="label-name">Sexo</p>

									<select name="c_sexo">
                                        <option value="N" class="form-option" <?= $res["sexo"] == "N" ? "selected" : "" ?>>Não definido</option>

                                        <option value="M" class="form-option" <?= $res["sexo"] == "M" ? "selected" : "" ?>>Masculino</option>
                                        <option value="F" class="form-option" <?= $res["sexo"] == "F" ? "selected" : "" ?>>Feminino</option>
                                    </select>
								</label>

                                <label class="input-label">
                                    <p class="label-name">Data de Nascimento</p>
                                    <input type="date" name="c_nascimento" class="form-input"
                                        placeholder="Nascimento" value="<?= $res["data_nascimento"] ?>">
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Estado Civil</p>
                                    <select name="c_estado_civil" required>
                                        <option value="Solteiro(a)" class="form_option" <?= $res["estado_civil"] == "Solteiro" ? "selected" : "" ?>>Solteiro(a)</option>
                                        <option value="Casado(a)" class="form_option" <?= $res["estado_civil"] == "Casado" ? "selected" : "" ?>>Casado(a)</option>
                                        <option value="União Estável" class="form_option" <?= $res["estado_civil"] == "União Estável" ? "selected" : "" ?>>União Estável</option>
                                        <option value="Viúvo(a)" class="form_option" <?= $res["estado_civil"] == "Viúvo" ? "selected" : "" ?>>Viúvo(a)</option>
                                        <option value="Separado(a)" class="form_option" <?= $res["estado_civil"] == "Separado" ? "selected" : "" ?>>Separado(a) Judicialmente</option>
                                        <option value="Divorciado(a)" class="form_option" <?= $res["estado_civil"] == "Divorciado" ? "selected" : "" ?>>Divorciado(a)</option>
                                    </select>
                                </label>
                            </div>
                        </div>

                        <div class="form-section">
                            <h2 class="form-section-title">Localização</h2>

                            <div class="inputs-wrapper">
                                <label class="input-label">
                                    <p class="label-name">CEP</p>
                                    <input type="text" name="c_cep" id="cep" class="form-input" placeholder="CEP"
                                        data-mask="00000-000" value="<?= $res["cep"] ?>" required>
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Endereço</p>
                                    <input type="text" name="c_endereco" id="endereco" class="form-input"
                                        placeholder="Endereço" value="<?= $res["endereco"] ?>" required>
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Cidade</p>
                                    <input type="text" name="c_cidade" id="cidade" class="form-input"
                                        placeholder="Cidade" value="<?= $res["cidade"] ?>" required>
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Estado</p>
                                    <select name="c_estado" id="estado" required>
                                        <option value="AC" class="form_option" <?= $res["estado"] == "AC" ? "selected" : "" ?>>AC</option>
                                        <option value="AL" class="form_option" <?= $res["estado"] == "AL" ? "selected" : "" ?>>AL</option>
                                        <option value="AP" class="form_option" <?= $res["estado"] == "AP" ? "selected" : "" ?>>AP</option>
                                        <option value="AM" class="form_option" <?= $res["estado"] == "AM" ? "selected" : "" ?>>AM</option>
                                        <option value="BA" class="form_option" <?= $res["estado"] == "BA" ? "selected" : "" ?>>BA</option>
                                        <option value="CE" class="form_option" <?= $res["estado"] == "CE" ? "selected" : "" ?>>CE</option>
                                        <option value="DF" class="form_option" <?= $res["estado"] == "DF" ? "selected" : "" ?>>DF</option>
                                        <option value="ES" class="form_option" <?= $res["estado"] == "ES" ? "selected" : "" ?>>ES</option>
                                        <option value="GO" class="form_option" <?= $res["estado"] == "GO" ? "selected" : "" ?>>GO</option>
                                        <option value="MA" class="form_option" <?= $res["estado"] == "MA" ? "selected" : "" ?>>MA</option>
                                        <option value="MT" class="form_option" <?= $res["estado"] == "MT" ? "selected" : "" ?>>MT</option>
                                        <option value="MS" class="form_option" <?= $res["estado"] == "MS" ? "selected" : "" ?>>MS</option>
                                        <option value="MG" class="form_option" <?= $res["estado"] == "MG" ? "selected" : "" ?>>MG</option>
                                        <option value="PA" class="form_option" <?= $res["estado"] == "PA" ? "selected" : "" ?>>PA</option>
                                        <option value="PB" class="form_option" <?= $res["estado"] == "PB" ? "selected" : "" ?>>PB</option>
                                        <option value="PR" class="form_option" <?= $res["estado"] == "PR" ? "selected" : "" ?>>PR</option>
                                        <option value="PE" class="form_option" <?= $res["estado"] == "PE" ? "selected" : "" ?>>PE</option>
                                        <option value="PI" class="form_option" <?= $res["estado"] == "PI" ? "selected" : "" ?>>PI</option>
                                        <option value="RJ" class="form_option" <?= $res["estado"] == "RJ" ? "selected" : "" ?>>RJ</option>
                                        <option value="RN" class="form_option" <?= $res["estado"] == "RN" ? "selected" : "" ?>>RN</option>
                                        <option value="RS" class="form_option" <?= $res["estado"] == "RS" ? "selected" : "" ?>>RS</option>
                                        <option value="RO" class="form_option" <?= $res["estado"] == "RO" ? "selected" : "" ?>>RO</option>
                                        <option value="RR" class="form_option" <?= $res["estado"] == "RR" ? "selected" : "" ?>>RR</option>
                                        <option value="SC" class="form_option" <?= $res["estado"] == "SC" ? "selected" : "" ?>>SC</option>
                                        <option value="SP" class="form_option" <?= $res["estado"] == "SP" ? "selected" : "" ?>>SP</option>
                                        <option value="SE" class="form_option" <?= $res["estado"] == "SE" ? "selected" : "" ?>>SE</option>
                                        <option value="TO" class="form_option" <?= $res["estado"] == "TO" ? "selected" : "" ?>>TO</option>
                                    </select>
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Bairro</p>
                                    <input type="text" name="c_bairro" id="bairro" class="form-input"
                                        placeholder="Bairro" value="<?= $res["bairro"] ?>" required>
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Número</p>
                                    <input type="text" name="c_numero" class="form-input"
                                        placeholder="Número" value="<?= $res["numero"] ?>" required>
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Complemento</p>
                                    <input type="text" name="c_complemento" class="form-input"
                                        placeholder="Complemento" value="<?= $res["complemento"] ?>">
                                </label>
                            </div>
                        </div>

                        <div class="form-section">
                            <h2 class="form-section-title">Dados cadastrais</h2>

                            <div class="inputs-wrapper">
                                <label class="input-label">
                                    <p class="label-name">E-mail</p>
                                    <input type="text" name="c_email" class="form-input" placeholder="email@example.com" value="<?= $res["email"] ?>">
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Senha</p>
                                    <input type="text" name="c_senha" class="form-input" placeholder="Senha" value="<?= $res["senha"] ?>">
                                </label>
                            </div>
                        </div>

                        <input type="hidden" name="cadastrar" value="true">

                        <!-- Input Hidden do ID recebido de filtrar-cliente.php (URL) -->
                        <input type="hidden" name="c_id" value="<?= $selectedIdCliente ?>">

                        <button type="submit" class="default-button dashboard-button">Atualizar</button>
                    </form>
                </div>
            </section>
        </main>
    </div>

    <!-- Script Dashboard -->
    <script src="../../custom/js/dashboard.js"></script>
    <script src="../../custom/js/message-box.js"></script>
    <script src="../../custom/js/via-cep.js"></script>
</body>

</html>