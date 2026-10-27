<?php

// Verificando se existe um usuário logado para permitir acesso a esta página
include_once __DIR__ . "/../UsuarioComum.php";

require_once __DIR__ . "/../../connection/connection.php";
require_once __DIR__ . "/Cliente.php";
require_once __DIR__ . "/RepositorioCliente.php";

// Input Hidden
$insertRequest = $_POST["cadastrar"] ?? null;

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
        $civil
    );

    $repos = new RepositorioCliente($pdo);

    try {
        $repos->Cadastrar($cliente);
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
            <p class="message-body">Não foi possível concluir o cadastro. <br> Detalhes: ' . $e->getMessage() .'</p>
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
                    <i class="fa-solid fa-user-pen icon-section"></i>
                    <h2 class="section-title">Cadastrar clientes</h2>
                </div>

                <div class="form-container">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-section">
                            <h2 class="form-section-title">Informações gerais</h2>

                            <div class="inputs-wrapper">
                                <label class="input-label">
                                    <p class="label-name">Status</p>

                                    <select name="c_status" disabled>
                                        <option value="1" class="form-option" selected>Ativo</option>
                                        <option value="0" class="form-option">Inativo</option>
                                    </select>
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Nome</p>
                                    <input type="text" name="c_nome" class="form-input" placeholder="Nome do cliente" required>
                                </label>

                                <label class="input-label">
                                    <p class="label-name">CPF</p>
                                    <input type="text" name="c_cpf" class="form-input" placeholder="000.000.000-00" required>
                                </label>

                                <label class="input-label">
                                    <p class="label-name">RG</p>
                                    <input type="text" name="c_rg" class="form-input" placeholder="00.000.000-0">
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Telefone Residencial</p>
                                    <input type="text" name="c_residencial" class="form-input" placeholder="(00) 0000-0000">
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Telefone Celular</p>
                                    <input type="text" name="c_celular" class="form-input" placeholder="(00) 00000-0000">
                                </label>

                                <label class="input-label">
									<p class="label-name">Sexo</p>

									<select name="c_sexo">
										<option value="N" class="form-option" selected>Não informado</option>

										<option value="M" class="form-option">Masculino</option>
										<option value="F" class="form-option">Feminino</option>
									</select>
								</label>

                                <label class="input-label">
									<p class="label-name">Data de Nascimento</p>
									<input type="date" name="c_nascimento" class="form-input"
										placeholder="Nascimento" required>
								</label>

                                <label class="input-label">
									<p class="label-name">Estado Civil</p>
									<select name="c_estado_civil" required>
										<option value="Solteiro(a)" class="form_option">Solteiro(a)</option>
										<option value="Casado(a)" class="form_option">Casado(a)</option>
										<option value="União Estável" class="form_option">União Estável</option>
										<option value="Viúvo(a)" class="form_option">Viúvo(a)</option>
										<option value="Separado(a)" class="form_option">Separado(a) Judicialmente</option>
										<option value="Divorciado(a)" class="form_option">Divorciado(a)</option>
									</select>
								</label>
                            </div>
                        </div>

                        <div class="form-section">
                            <h2 class="form-section-title">Localização</h2>

                            <div class="inputs-wrapper">
                                <label class="input-label">
                                    <p class="label-name">CEP</p>
                                    <input type="text" name="c_cep" id="cep" class="form-input" placeholder="00000-000">
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Endereço</p>
                                    <input type="text" name="c_endereco" id="endereco" class="form-input" placeholder="Endereço" required>
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Cidade</p>
                                    <input type="text" name="c_cidade" id="cidade" class="form-input" placeholder="Cidade" required>
                                </label>

                                <label class="input-label">
									<p class="label-name">Estado</p>
									<select name="c_estado" id="estado" required>
										<option value="AC" class="form_option">AC</option>
										<option value="AL" class="form_option">AL</option>
										<option value="AP" class="form_option">AP</option>
										<option value="AM" class="form_option">AM</option>
										<option value="BA" class="form_option">BA</option>
										<option value="CE" class="form_option">CE</option>
										<option value="DF" class="form_option">DF</option>
										<option value="ES" class="form_option">ES</option>
										<option value="GO" class="form_option">GO</option>
										<option value="MA" class="form_option">MA</option>
										<option value="MT" class="form_option">MT</option>
										<option value="MS" class="form_option">MS</option>
										<option value="MG" class="form_option">MG</option>
										<option value="PA" class="form_option">PA</option>
										<option value="PB" class="form_option">PB</option>
										<option value="PR" class="form_option">PR</option>
										<option value="PE" class="form_option">PE</option>
										<option value="PI" class="form_option">PI</option>
										<option value="RJ" class="form_option">RJ</option>
										<option value="RN" class="form_option">RN</option>
										<option value="RS" class="form_option">RS</option>
										<option value="RO" class="form_option">RO</option>
										<option value="RR" class="form_option">RR</option>
										<option value="SC" class="form_option">SC</option>
										<option value="SP" class="form_option">SP</option>
										<option value="SE" class="form_option">SE</option>
										<option value="TO" class="form_option">TO</option>
									</select>
								</label>

                                <label class="input-label">
                                    <p class="label-name">Bairro</p>
                                    <input type="text" name="c_bairro" id="bairro" class="form-input" placeholder="Bairro" required>
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Número</p>
                                    <input type="text" name="c_numero" class="form-input" placeholder="Nº" maxlength="5" required>
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Complemento</p>
                                    <input type="text" name="c_complemento" class="form-input" placeholder="Complemento">
                                </label>
                            </div>
                        </div>

                        <div class="form-section">
                            <h2 class="form-section-title">Dados cadastrais</h2>

                            <div class="inputs-wrapper">
                                <label class="input-label">
                                    <p class="label-name">E-mail</p>
                                    <input type="text" name="c_email" class="form-input" placeholder="email@example.com" required>
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Senha</p>
                                    <input type="text" name="c_senha" class="form-input" placeholder="Senha" required>
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
    <script src="../../custom/js/via-cep.js"></script>
</body>

</html>